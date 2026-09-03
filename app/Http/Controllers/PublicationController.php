<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\IndexPartner;
use App\Models\CurrentIssue;
use App\Models\Issue;
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

        $issueRecords = collect();

        if (Schema::hasTable('issues')) {
            $issueRecords = Issue::query()
                ->orderByDesc('publish_date')
                ->get()
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

        $archiveIssues = $query
            ->orderByDesc('year')
            ->orderByDesc('volume')
            ->orderByDesc('issue')
            ->orderBy('id')
            ->get()
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

                        return (object) [
                            'year' => $first->year,
                            'volume' => $first->volume,
                            'issue' => $first->issue,
                            'issue_range' => $first->issue_range,
                            'papers' => $papers,
                            'article_count' => $papers->count(),
                            'published_at' => $issueRecord?->publish_date,
                            'cover_image' => $coverIssueRecord?->cover_image,
                            'is_current' => $currentIssueKeys->has($first->volume . '|' . $first->issue),
                        ];
                    })
                    ->values();
            });

        $years = Publication::query()
            ->whereNotNull('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $volumes = Publication::query()
            ->whereNotNull('volume')
            ->distinct()
            ->orderByDesc('volume')
            ->pluck('volume');

        $partners = IndexPartner::latest()->get();

        return view('archive', compact(
            'archiveIssues',
            'years',
            'volumes',
            'filters',
            'partners'
        ));
    }

    public function adminIndex()
    {
        $publications = Publication::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.publications.index', compact('publications'));
    }

    public function create()
    {
        return view('admin.publications.create');
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
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('cover_image') && ! Schema::hasTable('issues')) {
            return back()
                ->withErrors(['cover_image' => 'The issues table is not available. Please run migrations before uploading archive covers.'])
                ->withInput();
        }

        $data = $request->except(['download_count', 'view_count', 'paper_pdf', 'certificate', 'cover_image']);

        if ($request->hasFile('paper_pdf')) {
            $data['paper_pdf'] = $request->file('paper_pdf')->store('publications', 'public');
        }

        if ($request->hasFile('certificate')) {
            $data['certificate_path'] = $request->file('certificate')->store('certificates', 'public');
        }

        $data['download_count'] = 0;

        Publication::create($data);

        if ($request->hasFile('cover_image')) {
            $archiveIssue = $this->issueForCover(
                $request->volume,
                $request->issue,
                $request->issue_range,
                $request->year
            );

            $archiveIssue->update([
                'cover_image' => $request->file('cover_image')->store('issue-covers', 'public'),
            ]);
        }

        return redirect()->route('admin.publications.index')
            ->with('success', 'Publication added successfully.');
    }

    public function edit(Publication $publication)
    {
        $archiveIssue = $this->matchingIssue($publication->volume, $publication->issue);

        return view('admin.publications.edit', compact('publication', 'archiveIssue'));
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
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('cover_image') && ! Schema::hasTable('issues')) {
            return back()
                ->withErrors(['cover_image' => 'The issues table is not available. Please run migrations before uploading archive covers.'])
                ->withInput();
        }

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

        if ($request->hasFile('cover_image')) {
            $archiveIssue = $this->issueForCover(
                $request->volume,
                $request->issue,
                $request->issue_range,
                $request->year
            );

            // Keep the previous cover file so replacing an image never removes existing data.
            $archiveIssue->update([
                'cover_image' => $request->file('cover_image')->store('issue-covers', 'public'),
            ]);
        }

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

        $issueMeta = Schema::hasTable('issues')
            ? Issue::where('volume', $volume)
                ->where('number', $issue)
                ->orderByDesc('publish_date')
                ->first()
            : null;

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

    private function matchingIssue($volume, $issue): ?Issue
    {
        if (! Schema::hasTable('issues')) {
            return null;
        }

        return Issue::where('volume', (string) $volume)
            ->where('number', (string) $issue)
            ->latest('id')
            ->first();
    }

    private function issueForCover($volume, $issue, ?string $issueRange = null, $year = null): ?Issue
    {
        $existingIssue = $this->matchingIssue($volume, $issue);

        if ($existingIssue) {
            return $existingIssue;
        }

        if (! Schema::hasTable('issues')) {
            return null;
        }

        return Issue::create([
            'title' => $issueRange ?: 'Volume ' . $volume . ' - Issue ' . $issue,
            'volume' => (string) $volume,
            'number' => (string) $issue,
            'year' => $year ? (string) $year : null,
        ]);
    }

}
