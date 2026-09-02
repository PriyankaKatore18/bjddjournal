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
                        $issueRecord = $issueRecords
                            ->get($first->volume . '|' . $first->issue, collect())
                            ->first();

                        return (object) [
                            'year' => $first->year,
                            'volume' => $first->volume,
                            'issue' => $first->issue,
                            'issue_range' => $first->issue_range,
                            'papers' => $papers,
                            'article_count' => $papers->count(),
                            'published_at' => $issueRecord?->publish_date,
                            'cover_image' => $issueRecord?->cover_image,
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
            'abstract' => 'nullable|string',
            'keywords' => 'nullable|string',
            'paper_pdf' => 'nullable|mimes:pdf|max:20480',
            'certificate' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $data = $request->except('download_count');

        if ($request->hasFile('paper_pdf')) {
            $data['paper_pdf'] = $request->file('paper_pdf')->store('publications', 'public');
        }

        if ($request->hasFile('certificate')) {
            $data['certificate_path'] = $request->file('certificate')->store('certificates', 'public');
        }

        $data['download_count'] = 0;

        Publication::create($data);

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
            'abstract' => 'nullable|string',
            'keywords' => 'nullable|string',
            'paper_pdf' => 'nullable|mimes:pdf|max:20480',
            'certificate' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $data = $request->except('download_count');

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

    public function articleDetails(string $publicationKey)
    {
        $publication = ArticleHelper::findByRouteKey($publicationKey);

        abort_unless($publication, 404);

        $canonicalKey = ArticleHelper::routeKey($publication);

        if (ctype_digit($publicationKey) || $publicationKey !== $canonicalKey) {
            return redirect()
                ->route('article.details', ['publicationKey' => $canonicalKey])
                ->setStatusCode(301);
        }

        return view('article-details', [
            'publication' => $publication,
            'citations' => ArticleHelper::citations($publication),
            'articleKey' => $canonicalKey,
        ]);
    }

    public function blogs()
    {
        $blogs = Blog::latest()->paginate(9);

        return view('blogs', compact('blogs'));
    }

}
