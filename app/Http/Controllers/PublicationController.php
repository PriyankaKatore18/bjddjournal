<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\IndexPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PublicationController extends Controller
{
    public function index()
    {
        $publications = Publication::orderBy('volume', 'desc')
            ->orderBy('issue', 'desc')
            ->get()
            ->groupBy(function ($publication) {
                $issueRange = $publication->issue_range ?? 'No Range Specified';
                return "Volume {$publication->volume}, Issue {$publication->issue} ({$issueRange})";
            });

        $partners = IndexPartner::latest()->get();

        return view('archive', compact('publications', 'partners'));
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
            ->latest()
            ->paginate(5);

        return view('issue-details', compact(
            'papers',
            'volume',
            'issue'
        ));
    }

    public function articleDetails(Publication $publication)
    {
        return view(
            'article-details',
            compact('publication')

        );
    }

    public function blogs()
    {
        $blogs = Blog::latest()->paginate(9);

        return view('blogs', compact('blogs'));
    }

}
