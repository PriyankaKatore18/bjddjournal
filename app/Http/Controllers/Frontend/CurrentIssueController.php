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

        if (! $currentIssue && Schema::hasTable('issues')) {
            $latestAdminIssue = Issue::query()
                ->whereNotNull('volume')
                ->whereNotNull('number')
                ->orderByDesc('publish_date')
                ->orderByDesc('year')
                ->orderByDesc('volume')
                ->orderByDesc('number')
                ->orderByDesc('created_at')
                ->first();

            if ($latestAdminIssue) {
                $currentIssue = $this->currentIssueFromIssue($latestAdminIssue);
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
            $issuesQuery = Issue::orderByDesc('created_at')
                ->orderByDesc('publish_date');

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

    private function currentIssueFromIssue(Issue $issue): object
    {
        return (object) [
            'volume' => $issue->volume,
            'issue' => $issue->number,
            'month_year' => $issue->title ?: 'Volume ' . $issue->volume . ' - Issue ' . $issue->number,
            'e_issn' => $issue->approved_eissn,
        ];
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
