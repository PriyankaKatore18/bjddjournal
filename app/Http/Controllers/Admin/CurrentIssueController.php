<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CurrentIssue;
use App\Models\BusinessSetting;
use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CurrentIssueController extends Controller
{
    public function edit()
    {
        if (Schema::hasTable('current_issues')) {
            $currentIssue = CurrentIssue::where('is_active', true)->first();
        } else {
            $currentIssue = (object) [
                'volume' => '1',
                'issue' => '3',
                'month_year' => 'September – October 2025',
                'e_issn' => 'Applied / Under Process',
                'last_submission_date' => '2025-10-25',
                'home_cover' => null,
            ];
        }

        return view('admin.current-issue.edit', compact('currentIssue'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'volume' => 'required|string',
            'issue' => 'required|string',
            'month_year' => 'required|string',
            'e_issn' => 'required|string|max:100',
            'last_submission_date' => 'required|date',
            'home_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);


        if (!Schema::hasTable('current_issues')) {
            return redirect()->route('admin.current-issue.edit')
                ->with('error', 'Database table not found. Please run migrations first.');
        }

        if ($request->hasFile('home_cover')) {

            $file = $request->file('home_cover');

            $homeCoverPath = $file->getClientOriginalName();

            $homeCoverPath = str_replace(' ', '-', $homeCoverPath);

            $oldSetting = BusinessSetting::where('key', 'home_cover')->first();

            if ($oldSetting && $oldSetting->value && Storage::disk('public')->exists($oldSetting->value)) {
                Storage::disk('public')->delete($oldSetting->value);
            }

            $file->storeAs('', $homeCoverPath, 'public');

            BusinessSetting::where('key', 'home_cover')->delete();

            BusinessSetting::create([
                'key' => 'home_cover',
                'value' => $homeCoverPath,
            ]);
        }

        // Deactivate all current issues
        CurrentIssue::query()->update(['is_active' => false]);


        $currentIssue = CurrentIssue::create([
            'volume' => $request->volume,
            'issue' => $request->issue,
            'month_year' => $request->month_year,
            'e_issn' => $request->e_issn,
            'last_submission_date' => $request->last_submission_date,
            'is_active' => true,
        ]);

        $this->syncIssueRecord($currentIssue);

        return redirect()->route('admin.current-issue.edit')
            ->with('success', 'Current issue updated successfully!');
    }

    private function syncIssueRecord(CurrentIssue $currentIssue): void
    {
        if (! Schema::hasTable('issues')) {
            return;
        }

        $issue = Issue::firstOrNew([
            'volume' => (string) $currentIssue->volume,
            'number' => (string) $currentIssue->issue,
        ]);

        $issue->title = $currentIssue->month_year
            ?: 'Volume ' . $currentIssue->volume . ' - Issue ' . $currentIssue->issue;

        if (Schema::hasColumn('issues', 'approved_eissn')) {
            $issue->approved_eissn = $currentIssue->e_issn;
        }

        if (Schema::hasColumn('issues', 'year')) {
            $issue->year = $this->yearFromText($currentIssue->month_year) ?: $issue->year;
        }

        if (! $issue->exists && Schema::hasColumn('issues', 'downloads_count')) {
            $issue->downloads_count = 0;
        }

        if ($issue->isDirty()) {
            $issue->save();
        }
    }

    private function yearFromText(?string $value): ?string
    {
        if (preg_match('/\b(19|20)\d{2}\b/', (string) $value, $matches)) {
            return $matches[0];
        }

        return null;
    }
}
