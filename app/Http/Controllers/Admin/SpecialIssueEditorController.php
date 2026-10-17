<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialIssue;
use App\Models\SpecialIssueEditor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpecialIssueEditorController extends Controller
{
    public function edit(SpecialIssue $specialIssue)
    {
        $specialIssue->load('editors');

        return view('admin.special-issues.editorial-details', compact('specialIssue'));
    }

    public function updateDetails(Request $request, SpecialIssue $specialIssue)
    {
        $data = $request->validate([
            'editorial_details' => 'nullable|string',
        ]);

        $specialIssue->update($data);

        return redirect()
            ->route('admin.special-issues.editorial-details.edit', $specialIssue)
            ->with('success', 'Editorial / Conference Details updated successfully.');
    }

    public function store(Request $request, SpecialIssue $specialIssue)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('special-issues/editors', 'public');
        }

        $data['special_issue_id'] = $specialIssue->id;
        SpecialIssueEditor::create($data);

        return redirect()
            ->route('admin.special-issues.editorial-details.edit', $specialIssue)
            ->with('success', 'Editorial member added successfully.');
    }

    public function editEditor(SpecialIssue $specialIssue, SpecialIssueEditor $editor)
    {
        $this->ensureBelongsTo($specialIssue, $editor);

        return view('admin.special-issues.editorial-editor-edit', compact('specialIssue', 'editor'));
    }

    public function update(Request $request, SpecialIssue $specialIssue, SpecialIssueEditor $editor)
    {
        $this->ensureBelongsTo($specialIssue, $editor);
        $data = $this->validatedData($request, $editor);

        if ($request->hasFile('photo')) {
            if ($editor->photo && Storage::disk('public')->exists($editor->photo)) {
                Storage::disk('public')->delete($editor->photo);
            }

            $data['photo'] = $request->file('photo')->store('special-issues/editors', 'public');
        }

        $editor->update($data);

        return redirect()
            ->route('admin.special-issues.editorial-details.edit', $specialIssue)
            ->with('success', 'Editorial member updated successfully.');
    }

    public function destroy(SpecialIssue $specialIssue, SpecialIssueEditor $editor)
    {
        $this->ensureBelongsTo($specialIssue, $editor);

        if ($editor->photo && Storage::disk('public')->exists($editor->photo)) {
            Storage::disk('public')->delete($editor->photo);
        }

        $editor->delete();

        return redirect()
            ->route('admin.special-issues.editorial-details.edit', $specialIssue)
            ->with('success', 'Editorial member deleted successfully.');
    }

    private function validatedData(Request $request, ?SpecialIssueEditor $editor = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'display_order' => 'required|integer|min:0|max:9999',
        ]);
    }

    private function ensureBelongsTo(SpecialIssue $specialIssue, SpecialIssueEditor $editor): void
    {
        abort_unless($editor->special_issue_id === $specialIssue->id, 404);
    }
}
