<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\IndexPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CurrentIssueController extends Controller
{
    public function index()
    {
        $issues = Issue::orderBy('created_at', 'desc')->get();

        $partners = IndexPartner::latest()->get();

        return view('frontend.current-issue', compact('issues','partners'));
    }


    public function viewPdf(Issue $issue)
    {
        if (!$issue->published_paper_pdf || !Storage::disk('public')->exists($issue->published_paper_pdf)) {
            return redirect()->back()->with('error', 'PDF file not found.');
        }

        return Storage::disk('public')->response(
            $issue->published_paper_pdf,
            $issue->title . '.pdf',
            ['Content-Disposition' => 'inline']
        );
    }
}
