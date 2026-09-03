<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\Issue;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    public function edit(Request $request)
    {
        $this->ensureArchiveIssuesExist();

        $archiveIssues = $this->archiveIssues();
        $selectedIssue = $this->selectedIssue($request, $archiveIssues);
        $articleCounts = $this->publicationIssueCounts();
        $settings = $this->archiveSettings();

        return view('admin.archive.edit', compact(
            'archiveIssues',
            'selectedIssue',
            'articleCounts',
            'settings'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'archive_title' => 'nullable|string|max:255',
            'archive_description' => 'nullable|string',
            'issue_id' => 'nullable|integer|exists:issues,id',
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'volume' => 'required|string|max:50',
            'number' => 'required|string|max:50',
            'publish_date' => 'nullable|date',
            'year' => 'nullable|string|max:20',
            'approved_eissn' => 'nullable|string|max:50',
            'published_paper_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $this->saveArchiveSettings(
            $request->input('archive_title'),
            $request->input('archive_description')
        );

        $issue = $request->filled('issue_id')
            ? Issue::findOrFail((int) $request->input('issue_id'))
            : Issue::firstOrNew([
                'volume' => (string) $request->volume,
                'number' => (string) $request->number,
            ]);

        $issue->fill($request->only([
            'title',
            'abstract',
            'volume',
            'number',
            'publish_date',
            'year',
            'approved_eissn',
        ]));

        if (! $issue->exists && ! $issue->downloads_count) {
            $issue->downloads_count = 0;
        }

        if ($request->hasFile('published_paper_pdf')) {
            if ($issue->published_paper_pdf && Storage::disk('public')->exists($issue->published_paper_pdf)) {
                Storage::disk('public')->delete($issue->published_paper_pdf);
            }

            $issue->published_paper_pdf = $request->file('published_paper_pdf')
                ->store('publications', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $issue->cover_image = $request->file('cover_image')
                ->store('issue-covers', 'public');
        }

        $issue->save();

        return redirect()
            ->route('admin.archive.edit', ['issue' => $issue->id])
            ->with('success', 'Archive issue updated successfully.');
    }

    private function ensureArchiveIssuesExist(): void
    {
        if (! Schema::hasTable('issues') || ! Schema::hasTable('publications')) {
            return;
        }

        Publication::query()
            ->select('id', 'paper_title', 'volume', 'issue', 'issue_range', 'year', 'eissn')
            ->whereNotNull('volume')
            ->whereNotNull('issue')
            ->orderByDesc('year')
            ->orderByDesc('volume')
            ->orderByDesc('issue')
            ->orderBy('id')
            ->get()
            ->groupBy(fn (Publication $publication) => $publication->volume . '|' . $publication->issue)
            ->each(function ($publications) {
                $publication = $publications->first();

                $issue = Issue::firstOrNew([
                    'volume' => (string) $publication->volume,
                    'number' => (string) $publication->issue,
                ]);

                if (! $issue->exists || $this->shouldUsePublicationIssueTitle($issue, $publications)) {
                    $issue->title = $publication->issue_range
                        ?: 'Volume ' . $publication->volume . ' - Issue ' . $publication->issue;
                }

                if (! $issue->year && $publication->year) {
                    $issue->year = (string) $publication->year;
                }

                if (! $issue->approved_eissn && $publication->eissn) {
                    $issue->approved_eissn = $publication->eissn;
                }

                if (! $issue->exists) {
                    $issue->downloads_count = 0;
                }

                if ($issue->isDirty()) {
                    $issue->save();
                }
            });
    }

    private function archiveIssues()
    {
        if (! Schema::hasTable('issues')) {
            return collect();
        }

        return Issue::query()
            ->orderByDesc('year')
            ->orderByDesc('volume')
            ->orderByDesc('number')
            ->orderByDesc('created_at')
            ->get();
    }

    private function selectedIssue(Request $request, $archiveIssues): ?Issue
    {
        if ($request->filled('issue')) {
            $selectedIssue = $archiveIssues->firstWhere('id', (int) $request->query('issue'));

            if ($selectedIssue) {
                return $selectedIssue;
            }
        }

        return $archiveIssues->first();
    }

    private function publicationIssueCounts()
    {
        if (! Schema::hasTable('publications')) {
            return collect();
        }

        return Publication::query()
            ->selectRaw('volume, issue, COUNT(*) as articles_count')
            ->whereNotNull('volume')
            ->whereNotNull('issue')
            ->groupBy('volume', 'issue')
            ->get()
            ->mapWithKeys(fn ($publication) => [
                $publication->volume . '|' . $publication->issue => (int) $publication->articles_count,
            ]);
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

    private function saveArchiveSettings(?string $title, ?string $description): void
    {
        if (! Schema::hasTable('business_settings')) {
            return;
        }

        BusinessSetting::updateOrCreate(
            ['key' => 'archive_title'],
            ['value' => $title ?: 'Publication Archive']
        );

        BusinessSetting::updateOrCreate(
            ['key' => 'archive_description'],
            ['value' => $description ?: 'Browse published articles by year, volume, and issue.']
        );
    }

    private function shouldUsePublicationIssueTitle(Issue $issue, $publications): bool
    {
        $title = trim((string) $issue->title);

        if ($title === '') {
            return true;
        }

        return $publications->contains(
            fn (Publication $publication) => trim((string) $publication->paper_title) === $title
        );
    }
}
