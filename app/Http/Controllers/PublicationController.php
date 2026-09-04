<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\IndexPartner;
use App\Models\CurrentIssue;
use App\Models\Issue;
use App\Models\BusinessSetting;
use App\Support\ArticleHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PublicationController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'search' => trim((string) $request->query('search', '')),
            'year' => $request->query('year'),
            'volume' => $request->query('volume'),
        ];

        $query = Publication::query();

        if ($filters['search'] !== '') {
            $search = $filters['search'];
            $query->where(function ($builder) use ($search) {
                $builder->where('paper_title', 'like', "%{$search}%")
                    ->orWhere('author_name', 'like', "%{$search}%")
                    ->orWhere('published_paper_id', 'like', "%{$search}%")
                    ->orWhere('registration_id', 'like', "%{$search}%")
                    ->orWhere('crossref_doi', 'like', "%{$search}%");
            });
        }

        if ($filters['year'] !== null && $filters['year'] !== '') {
            $query->where('year', $filters['year']);
        }

        if ($filters['volume'] !== null && $filters['volume'] !== '') {
            $query->where('volume', $filters['volume']);
        }

        $issueRecordList = collect();
        $issueRecords = collect();

        if (Schema::hasTable('issues')) {
            $issueQuery = Issue::query();

            if ($filters['search'] !== '') {
                $search = $filters['search'];
                $issueQuery->where(function ($builder) use ($search) {
                    $builder->where('title', 'like', "%{$search}%")
                        ->orWhere('abstract', 'like', "%{$search}%")
                        ->orWhere('published_paper_id', 'like', "%{$search}%")
                        ->orWhere('registration_id', 'like', "%{$search}%")
                        ->orWhere('crossref_doi_member_id', 'like', "%{$search}%");
                });
            }

            if ($filters['year'] !== null && $filters['year'] !== '') {
                $issueQuery->where('year', $filters['year']);
            }

            if ($filters['volume'] !== null && $filters['volume'] !== '') {
                $issueQuery->where('volume', $filters['volume']);
            }

            $issueRecordList = $issueQuery
                ->orderByDesc('year')
                ->orderByDesc('volume')
                ->orderByDesc('number')
                ->orderByDesc('publish_date')
                ->orderByDesc('created_at')
                ->get();

            $issueRecords = $issueRecordList
                ->groupBy(fn (Issue $issue) => $issue->volume . '|' . $issue->number);
        }

        $currentIssueKeys = collect();

        if (Schema::hasTable('current_issues')) {
            $currentIssueKeys = CurrentIssue::active()
                ->get(['volume', 'issue'])
                ->mapWithKeys(fn (CurrentIssue $currentIssue) => [
                    $currentIssue->volume . '|' . $currentIssue->issue => true,
                ]);
        }

        $publicationRecords = $query
            ->orderByDesc('year')
            ->orderByDesc('volume')
            ->orderByDesc('issue')
            ->orderBy('id')
            ->get();

        $publicationIssueKeys = $publicationRecords
            ->mapWithKeys(fn (Publication $publication) => [
                $publication->volume . '|' . $publication->issue => true,
            ]);

        $archiveIssues = $publicationRecords
            ->groupBy(fn (Publication $publication) => (string) ($publication->year ?: 'Other'))
            ->map(function ($yearPublications) use ($issueRecords, $currentIssueKeys) {
                return $yearPublications
                    ->groupBy(fn (Publication $publication) => implode('|', [
                        $publication->volume,
                        $publication->issue,
                        $publication->issue_range ?: 'No Range Specified',
                    ]))
                    ->map(function ($papers) use ($issueRecords, $currentIssueKeys) {
                        $first = $papers->first();
                        $matchingIssueRecords = $issueRecords
                            ->get($first->volume . '|' . $first->issue, collect());
                        $issueRecord = $matchingIssueRecords->first();
                        $coverIssueRecord = $matchingIssueRecords
                            ->first(fn (Issue $issue) => ! empty($issue->cover_image)) ?: $issueRecord;
                        $displayIssueRecord = $coverIssueRecord ?: $issueRecord;

                        return (object) [
                            'year' => $first->year,
                            'volume' => $first->volume,
                            'issue' => $first->issue,
                            'issue_range' => $first->issue_range,
                            'title' => $displayIssueRecord?->title ?: $first->issue_range,
                            'description' => $displayIssueRecord?->abstract,
                            'papers' => $papers,
                            'article_count' => $papers->count(),
                            'published_at' => $issueRecord?->publish_date,
                            'cover_image' => $coverIssueRecord?->cover_image,
                            'is_current' => $currentIssueKeys->has($first->volume . '|' . $first->issue),
                        ];
                    })
                    ->values();
            });

        $issueRecordList
            ->filter(fn (Issue $issue) => $issue->volume && $issue->number)
            ->reject(fn (Issue $issue) => $publicationIssueKeys->has($issue->volume . '|' . $issue->number))
            ->groupBy(function (Issue $issue) {
                if ($issue->year) {
                    return (string) $issue->year;
                }

                return $issue->publish_date
                    ? (string) date('Y', strtotime($issue->publish_date))
                    : 'Other';
            })
            ->each(function ($standaloneIssues, $year) use (&$archiveIssues, $currentIssueKeys) {
                $mappedIssues = $standaloneIssues->map(function (Issue $issue) use ($currentIssueKeys) {
                    return (object) [
                        'year' => $issue->year ?: ($issue->publish_date ? date('Y', strtotime($issue->publish_date)) : null),
                        'volume' => $issue->volume,
                        'issue' => $issue->number,
                        'issue_range' => $issue->title,
                        'title' => $issue->title,
                        'description' => $issue->abstract,
                        'papers' => collect(),
                        'article_count' => 0,
                        'published_at' => $issue->publish_date,
                        'cover_image' => $issue->cover_image,
                        'is_current' => $currentIssueKeys->has($issue->volume . '|' . $issue->number),
                    ];
                });

                $archiveIssues->put(
                    $year,
                    $archiveIssues->get($year, collect())->concat($mappedIssues)->values()
                );
            });

        $archiveIssues = $archiveIssues->sortKeysDesc();

        $years = Publication::query()
            ->whereNotNull('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        if (Schema::hasTable('issues')) {
            $years = $years
                ->merge(Issue::query()->whereNotNull('year')->distinct()->pluck('year'))
                ->filter()
                ->unique()
                ->sortDesc()
                ->values();
        }

        $volumes = Publication::query()
            ->whereNotNull('volume')
            ->distinct()
            ->orderByDesc('volume')
            ->pluck('volume');

        if (Schema::hasTable('issues')) {
            $volumes = $volumes
                ->merge(Issue::query()->whereNotNull('volume')->distinct()->pluck('volume'))
                ->filter()
                ->unique()
                ->sortDesc()
                ->values();
        }

        $partners = IndexPartner::latest()->get();
        $archiveSettings = $this->archiveSettings();

        return view('archive', compact(
            'archiveIssues',
            'years',
            'volumes',
            'filters',
            'partners',
            'archiveSettings'
        ));
    }

    public function adminIndex()
    {
        $publications = Publication::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.publications.index', compact('publications'));
    }

    public function create()
    {
        return view('admin.publications.create', [
            'currentIssueDefaults' => $this->currentIssueDefaults(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'volume' => 'required|integer',
            'issue' => 'required|integer',
            'issue_range' => 'required|string',
            'paper_title' => 'required|string',
            'author_name' => 'required|string',
            'registration_id' => 'required|string',
            'published_paper_id' => 'required|string',
            'year' => 'required|integer',
            'article_type' => 'nullable|string|max:255',
            'publication_type' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'frequency' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'abstract' => 'nullable|string',
            'keywords' => 'nullable|string',
            'received_at' => 'nullable|date',
            'revised_at' => 'nullable|date',
            'accepted_at' => 'nullable|date',
            'published_online_at' => 'nullable|date',
            'paper_pdf' => 'nullable|mimes:pdf|max:20480',
            'certificate' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $data = $request->except(['download_count', 'view_count', 'paper_pdf', 'certificate', 'cover_image']);

        if ($request->hasFile('paper_pdf')) {
            $data['paper_pdf'] = $request->file('paper_pdf')->store('publications', 'public');
        }

        if ($request->hasFile('certificate')) {
            $data['certificate_path'] = $request->file('certificate')->store('certificates', 'public');
        }

        $data['download_count'] = 0;

        $publication = Publication::create($data);

        $this->syncIssueRecordForPublication($publication);

        return redirect()->route('admin.publications.index')
            ->with('success', 'Publication added successfully.');
    }

    public function edit(Publication $publication)
    {
        return view('admin.publications.edit', compact('publication'));
    }

    public function update(Request $request, Publication $publication)
    {
        $request->validate([
            'volume' => 'required|integer',
            'issue' => 'required|integer',
            'issue_range' => 'required|string',
            'paper_title' => 'required|string',
            'author_name' => 'required|string',
            'registration_id' => 'required|string',
            'published_paper_id' => 'required|string',
            'year' => 'required|integer',
            'article_type' => 'nullable|string|max:255',
            'publication_type' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'frequency' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'abstract' => 'nullable|string',
            'keywords' => 'nullable|string',
            'received_at' => 'nullable|date',
            'revised_at' => 'nullable|date',
            'accepted_at' => 'nullable|date',
            'published_online_at' => 'nullable|date',
            'paper_pdf' => 'nullable|mimes:pdf|max:20480',
            'certificate' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $data = $request->except(['download_count', 'view_count', 'paper_pdf', 'certificate', 'cover_image']);

        if ($request->hasFile('paper_pdf')) {
            // Delete old PDF if exists
            if ($publication->paper_pdf && Storage::disk('public')->exists($publication->paper_pdf)) {
                Storage::disk('public')->delete($publication->paper_pdf);
            }
            $data['paper_pdf'] = $request->file('paper_pdf')->store('publications', 'public');
        }

        if ($request->hasFile('certificate')) {
            if ($publication->certificate_path && Storage::disk('public')->exists($publication->certificate_path)) {
                Storage::disk('public')->delete($publication->certificate_path);
            }
            $data['certificate_path'] = $request->file('certificate')->store('certificates', 'public');
        }

        $publication->update($data);

        $this->syncIssueRecordForPublication($publication->refresh());

        return redirect()->route('admin.publications.index')
            ->with('success', 'Publication updated successfully.');
    }

    public function destroy(Publication $publication)
    {
        if ($publication->paper_pdf && Storage::disk('public')->exists($publication->paper_pdf)) {
            Storage::disk('public')->delete($publication->paper_pdf);
        }

        if ($publication->certificate_path && Storage::disk('public')->exists($publication->certificate_path)) {
            Storage::disk('public')->delete($publication->certificate_path);
        }

        $publication->delete();

        return redirect()->route('admin.publications.index')
            ->with('success', 'Publication deleted successfully.');
    }

    public function viewPdf(Publication $publication)
    {
        if (!$publication->paper_pdf || !Storage::disk('public')->exists($publication->paper_pdf)) {
            return redirect()->back()->with('error', 'PDF file not found.');
        }

        return Storage::disk('public')->response(
            $publication->paper_pdf,
            $publication->paper_title . '.pdf',
            ['Content-Disposition' => 'inline']
        );
    }

    public function trackDownloadAndDownload(Publication $publication)
    {
        if (! $publication->paper_pdf || ! Storage::disk('public')->exists($publication->paper_pdf)) {
            return redirect()->back()->with('error', 'PDF file not found.');
        }

        if (Schema::hasColumn('publications', 'download_count')) {
            $publication->increment('download_count');
        }

        return Storage::disk('public')->download($publication->paper_pdf);
    }

    public function issueDetails($volume, $issue)
    {
        $papers = Publication::where('volume', $volume)
            ->where('issue', $issue)
            ->orderBy('id')
            ->paginate(5);

        $issueRecords = Schema::hasTable('issues')
            ? Issue::where('volume', $volume)
                ->where('number', $issue)
                ->orderByDesc('publish_date')
                ->get()
            : collect();

        $issueMeta = $issueRecords->first(fn (Issue $issue) => ! empty($issue->cover_image))
            ?: $issueRecords->first();

        $currentIssue = Schema::hasTable('current_issues')
            ? CurrentIssue::active()
                ->where('volume', $volume)
                ->where('issue', $issue)
                ->latest()
                ->first()
            : null;

        return view('issue-details', compact(
            'papers',
            'volume',
            'issue',
            'issueMeta',
            'currentIssue'
        ));
    }

    public function articleDetails(Request $request, string $publicationKey)
    {
        $publication = ArticleHelper::findByRouteKey($publicationKey);

        abort_unless($publication, 404);

        $canonicalKey = ArticleHelper::routeKey($publication);

        if (ctype_digit($publicationKey) || $publicationKey !== $canonicalKey) {
            return redirect()
                ->route('article.details', ['publicationKey' => $canonicalKey])
                ->setStatusCode(301);
        }

        $relatedArticles = Publication::query()
            ->where('volume', $publication->volume)
            ->where('issue', $publication->issue)
            ->orderBy('id')
            ->get();

        $articleIndex = $relatedArticles->search(
            fn (Publication $article) => $article->getKey() === $publication->getKey()
        );

        $previousArticle = $articleIndex !== false && $articleIndex > 0
            ? $relatedArticles->get($articleIndex - 1)
            : null;
        $nextArticle = $articleIndex !== false
            ? $relatedArticles->get($articleIndex + 1)
            : null;

        $moreArticles = $relatedArticles
            ->reject(fn (Publication $article) => $article->getKey() === $publication->getKey())
            ->values();

        $articleViewKey = 'bjdd_article_viewed_' . $publication->getKey();

        if (Schema::hasColumn('publications', 'view_count')
            && (! $request->hasSession() || ! $request->session()->has($articleViewKey))) {
            $publication->increment('view_count');

            if ($request->hasSession()) {
                $request->session()->put($articleViewKey, true);
            }
        }

        return view('article-details', [
            'publication' => $publication,
            'citations' => ArticleHelper::citations($publication),
            'articleKey' => $canonicalKey,
            'previousArticle' => $previousArticle,
            'nextArticle' => $nextArticle,
            'moreArticles' => $moreArticles,
        ]);
    }

    public function blogs()
    {
        $blogs = Blog::latest()->paginate(9);

        return view('blogs', compact('blogs'));
    }

    private function currentIssueDefaults(): array
    {
        if (! Schema::hasTable('current_issues')) {
            return [];
        }

        $currentIssue = CurrentIssue::active()->latest()->first();

        if (! $currentIssue) {
            return [];
        }

        $year = $this->yearFromText($currentIssue->month_year);

        if (! $year && $currentIssue->last_submission_date) {
            $year = $currentIssue->last_submission_date->format('Y');
        }

        return [
            'volume' => $currentIssue->volume,
            'issue' => $currentIssue->issue,
            'issue_range' => $currentIssue->month_year,
            'year' => $year,
            'eissn' => $currentIssue->e_issn,
        ];
    }

    private function syncIssueRecordForPublication(Publication $publication): void
    {
        if (! Schema::hasTable('issues') || ! $publication->volume || ! $publication->issue) {
            return;
        }

        $issue = Issue::firstOrNew([
            'volume' => (string) $publication->volume,
            'number' => (string) $publication->issue,
        ]);

        if (! $issue->exists || $this->shouldUsePublicationIssueTitle($issue, $publication)) {
            $issue->title = $publication->issue_range
                ?: 'Volume ' . $publication->volume . ' - Issue ' . $publication->issue;
        }

        if (Schema::hasColumn('issues', 'year') && ! $issue->year && $publication->year) {
            $issue->year = (string) $publication->year;
        }

        if (Schema::hasColumn('issues', 'approved_eissn') && ! $issue->approved_eissn && $publication->eissn) {
            $issue->approved_eissn = $publication->eissn;
        }

        if (Schema::hasColumn('issues', 'publish_date') && ! $issue->publish_date && $publication->published_online_at) {
            $issue->publish_date = $publication->published_online_at;
        }

        if (! $issue->exists && Schema::hasColumn('issues', 'downloads_count')) {
            $issue->downloads_count = 0;
        }

        if ($issue->isDirty()) {
            $issue->save();
        }
    }

    private function shouldUsePublicationIssueTitle(Issue $issue, Publication $publication): bool
    {
        $title = trim((string) $issue->title);

        if ($title === '') {
            return true;
        }

        if ($title === trim((string) $publication->paper_title)) {
            return true;
        }

        return preg_match('/^Volume\s+\d+\s+-\s+Issue\s+\d+$/i', $title) === 1;
    }

    private function yearFromText(?string $value): ?string
    {
        if (preg_match('/\b(19|20)\d{2}\b/', (string) $value, $matches)) {
            return $matches[0];
        }

        return null;
    }

    private function archiveSettings(): array
    {
        $defaults = [
            'archive_title' => 'Publication Archive',
            'archive_description' => 'Browse published articles by year, volume, and issue.',
        ];

        if (! Schema::hasTable('business_settings')) {
            return $defaults;
        }

        $settings = BusinessSetting::whereIn('key', array_keys($defaults))
            ->pluck('value', 'key');

        return [
            'archive_title' => $settings->get('archive_title', $defaults['archive_title']),
            'archive_description' => $settings->get('archive_description', $defaults['archive_description']),
        ];
    }

}
