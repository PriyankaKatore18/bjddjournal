<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\IndexPartner;
use App\Models\Publication;
use App\Models\CurrentIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class CurrentIssueController extends Controller
{
    public function index()
    {
        $currentIssue = Schema::hasTable('current_issues')
            ? CurrentIssue::active()->latest()->first()
            : null;

        if (! $currentIssue) {
            $latestPublication = Publication::query()
                ->orderByDesc('year')
                ->orderByDesc('volume')
                ->orderByDesc('issue')
                ->first();

            if ($latestPublication) {
                $currentIssue = (object) [
                    'volume' => $latestPublication->volume,
                    'issue' => $latestPublication->issue,
                    'month_year' => $latestPublication->issue_range,
                    'e_issn' => $latestPublication->eissn,
                ];
            }
        }

        $publications = collect();

        if ($currentIssue) {
            $publications = Publication::where('volume', $currentIssue->volume)
                ->where('issue', $currentIssue->issue)
                ->orderBy('id')
                ->get();
        }

        $issues = collect();

        if (Schema::hasTable('issues')) {
            $issuesQuery = Issue::orderBy('created_at', 'desc');

            if ($currentIssue) {
                $issuesQuery->where('volume', $currentIssue->volume)
                    ->where('number', $currentIssue->issue);
            }

            $issues = $issuesQuery->get();
        }

        $partners = IndexPartner::latest()->get();

        return view('frontend.current-issue', compact(
            'issues',
            'publications',
            'currentIssue',
            'partners'
        ));
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
