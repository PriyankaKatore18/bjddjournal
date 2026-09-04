<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CurrentIssue;
use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class IssueController extends Controller
{
    /**
     * Display a listing of the issues.
     */
    public function index()
    {
        $query = Issue::query();

        if (Schema::hasTable('current_issues')) {
            $currentIssue = CurrentIssue::where('is_active', true)->first();

            if ($currentIssue) {
                $query->where('volume', (string) $currentIssue->volume)
                    ->where('number', (string) $currentIssue->issue);
            }
        }

        $issues = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.issues.index', compact('issues'));
    }

    /**
     * Show the form for creating a new issue.
     */
    public function create()
    {
        return view('admin.issues.create');
    }

    /**
     * Store a newly created issue in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string', // Added
            'volume' => 'required|string|max:50',
            'number' => 'required|string|max:50',
            'publish_date' => 'nullable|date',
            'registration_id' => 'nullable|string|max:100',
            'published_paper_id' => 'nullable|string|max:100',
            'year' => 'nullable|string|max:20',
            'approved_eissn' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
            'crossref_doi_member_id' => 'nullable|string|max:50',
            'page_no' => 'nullable|string|max:20',
            'downloads_count' => 'nullable|integer',
            'published_paper_url' => 'nullable|url|max:255',
            'published_paper_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'paper_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // Added
        ]);

        $data = $request->except(['published_paper_pdf', 'paper_certificate', 'cover_image']);

        // Handle PDF upload
        if ($request->hasFile('published_paper_pdf')) {
            $file = $request->file('published_paper_pdf');
            $originalName = str_replace(' ', '_', $file->getClientOriginalName());
            $filename = time() . '_' . $originalName;
            $filePath = $file->storeAs('publications', $filename, 'public');
            $data['published_paper_pdf'] = $filePath;
        }

        // Handle Certificate upload
        if ($request->hasFile('paper_certificate')) {
            $file = $request->file('paper_certificate');
            $originalName = str_replace(' ', '_', $file->getClientOriginalName());
            $filename = 'certificate_' . time() . '_' . $originalName;
            $filePath = $file->storeAs('certificates', $filename, 'public');
            $data['paper_certificate'] = $filePath;
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('issue-covers', 'public');
        }

        $issue = Issue::create($data);

        $this->publishAsCurrentIssue($issue);

        return redirect()->route('admin.issues.index')->with('success', 'Issue created and published on the frontend.');
    }

    /**
     * Show the form for editing the specified issue.
     */
    public function edit(Issue $issue)
    {
        return view('admin.issues.edit', compact('issue'));
    }

    /**
     * Update the specified issue in storage.
     */
    public function update(Request $request, Issue $issue)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string', // Added
            'volume' => 'required|string|max:50',
            'number' => 'required|string|max:50',
            'publish_date' => 'nullable|date',
            'registration_id' => 'nullable|string|max:100',
            'published_paper_id' => 'nullable|string|max:100',
            'year' => 'nullable|string|max:20',
            'approved_eissn' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
            'crossref_doi_member_id' => 'nullable|string|max:50',
            'page_no' => 'nullable|string|max:20',
            'downloads_count' => 'nullable|integer',
            'published_paper_url' => 'nullable|url|max:255',
            'published_paper_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'paper_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // Added
        ]);

        $data = $request->except(['published_paper_pdf', 'paper_certificate', 'cover_image']);

        // Handle PDF upload
        if ($request->hasFile('published_paper_pdf')) {
            // Delete old file if exists
            if ($issue->published_paper_pdf && Storage::disk('public')->exists($issue->published_paper_pdf)) {
                Storage::disk('public')->delete($issue->published_paper_pdf);
            }

            $file = $request->file('published_paper_pdf');
            $originalName = str_replace(' ', '_', $file->getClientOriginalName());
            $filename = time() . '_' . $originalName;
            $filePath = $file->storeAs('publications', $filename, 'public');
            $data['published_paper_pdf'] = $filePath;
        }

        // Handle Certificate upload
        if ($request->hasFile('paper_certificate')) {
            // Delete old file if exists
            if ($issue->paper_certificate && Storage::disk('public')->exists($issue->paper_certificate)) {
                Storage::disk('public')->delete($issue->paper_certificate);
            }

            $file = $request->file('paper_certificate');
            $originalName = str_replace(' ', '_', $file->getClientOriginalName());
            $filename = 'certificate_' . time() . '_' . $originalName;
            $filePath = $file->storeAs('certificates', $filename, 'public');
            $data['paper_certificate'] = $filePath;
        }

        if ($request->hasFile('cover_image')) {
            // Keep the previous cover file so replacing an image never removes existing data.
            $data['cover_image'] = $request->file('cover_image')->store('issue-covers', 'public');
        }

        $issue->update($data);

        $this->publishAsCurrentIssue($issue);

        return redirect()->route('admin.issues.edit', $issue)->with('success', 'Issue updated and published on the frontend.');
    }

    /**
     * Remove the specified issue from storage.
     */
    public function destroy(Issue $issue)
    {
        // Delete PDF file if exists
        if ($issue->published_paper_pdf && Storage::disk('public')->exists($issue->published_paper_pdf)) {
            Storage::disk('public')->delete($issue->published_paper_pdf);
        }

        // Delete certificate file if exists
        if ($issue->paper_certificate && Storage::disk('public')->exists($issue->paper_certificate)) {
            Storage::disk('public')->delete($issue->paper_certificate);
        }

        $issue->delete();

        $this->publishLatestAvailableIssue();

        return redirect()->route('admin.issues.index')->with('success', 'Issue deleted successfully.');
    }

    /**
     * View PDF for the specified issue (increments download count)
     */
    public function viewPdf(Issue $issue)
    {
        if ($issue->published_paper_pdf && Storage::disk('public')->exists($issue->published_paper_pdf)) {
            // Increment download count
            $issue->incrementDownloadCount();
            
            $filePath = Storage::disk('public')->path($issue->published_paper_pdf);
            return response()->file($filePath);
        }
        return redirect()->back()->with('error', 'PDF file not found.');
    }

    /**
     * Download PDF for the specified issue (increments download count)
     */
    public function downloadPdf(Issue $issue)
    {
        if ($issue->published_paper_pdf && Storage::disk('public')->exists($issue->published_paper_pdf)) {
            // Increment download count
            $issue->incrementDownloadCount();
            
            return Storage::disk('public')->download($issue->published_paper_pdf);
        }
        return redirect()->back()->with('error', 'PDF file not found.');
    }

    /**
     * View certificate for the specified issue
     */
    public function viewCertificate(Issue $issue)
    {
        if ($issue->paper_certificate && Storage::disk('public')->exists($issue->paper_certificate)) {
            $filePath = Storage::disk('public')->path($issue->paper_certificate);
            
            // Check if it's an image or PDF
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                return response()->file($filePath);
            } else {
                // For PDF certificates, return as file
                return response()->file($filePath);
            }
        }
        return redirect()->back()->with('error', 'Certificate file not found.');
    }

    private function publishAsCurrentIssue(Issue $issue): void
    {
        if (! Schema::hasTable('current_issues') || ! $issue->volume || ! $issue->number) {
            return;
        }

        CurrentIssue::query()->update(['is_active' => false]);

        $data = [
            'volume' => (string) $issue->volume,
            'issue' => (string) $issue->number,
            'month_year' => $issue->title ?: 'Volume ' . $issue->volume . ' - Issue ' . $issue->number,
            'is_active' => true,
        ];

        if (Schema::hasColumn('current_issues', 'e_issn')) {
            $data['e_issn'] = $issue->approved_eissn ?: 'Applied / Under Process';
        }

        if (Schema::hasColumn('current_issues', 'last_submission_date')) {
            $data['last_submission_date'] = $issue->publish_date ?: null;
        }

        CurrentIssue::create($data);
    }

    private function publishLatestAvailableIssue(): void
    {
        if (! Schema::hasTable('current_issues')) {
            return;
        }

        $latestIssue = Issue::query()
            ->whereNotNull('volume')
            ->whereNotNull('number')
            ->orderByDesc('publish_date')
            ->orderByDesc('year')
            ->orderByDesc('volume')
            ->orderByDesc('number')
            ->orderByDesc('created_at')
            ->first();

        if ($latestIssue) {
            $this->publishAsCurrentIssue($latestIssue);
            return;
        }

        CurrentIssue::query()->update(['is_active' => false]);
    }

}
