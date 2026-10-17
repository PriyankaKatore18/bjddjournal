<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialIssue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpecialIssueController extends Controller
{
    public function index()
    {
        $specialIssues = SpecialIssue::withCount(['articles', 'publishedArticles'])
            ->latest()
            ->paginate(10);

        return view('admin.special-issues.index', compact('specialIssues'));
    }

    public function create()
    {
        $suggestedId = 'BJDD-SI-' . now()->format('Y') . '-' . str_pad((SpecialIssue::max('id') ?? 0) + 1, 3, '0', STR_PAD_LEFT);

        return view('admin.special-issues.create', compact('suggestedId'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('special-issues/covers', 'public');
        }

        foreach (['cover_pdf', 'index_pdf', 'full_issue_pdf'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field . '_path'] = $request->file($field)->store('special-issues/pdfs', 'public');
            }
        }

        $specialIssue = SpecialIssue::create($data);

        return redirect()
            ->route('admin.special-issues.editorial-details.edit', $specialIssue)
            ->with('success', 'Special issue created successfully. Add editorial / conference details next.');
    }

    public function show(SpecialIssue $specialIssue)
    {
        $specialIssue->loadCount(['articles', 'publishedArticles']);
        $articles = $specialIssue->articles()->latest()->paginate(10);

        return view('admin.special-issues.manage', compact('specialIssue', 'articles'));
    }

    public function edit(SpecialIssue $specialIssue)
    {
        return $this->show($specialIssue);
    }

    public function update(Request $request, SpecialIssue $specialIssue)
    {
        $data = $this->validatedData($request, $specialIssue);

        if ($request->hasFile('cover_image')) {
            if ($specialIssue->cover_image && Storage::disk('public')->exists($specialIssue->cover_image)) {
                Storage::disk('public')->delete($specialIssue->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')->store('special-issues/covers', 'public');
        }

        foreach (['cover_pdf', 'index_pdf', 'full_issue_pdf'] as $field) {
            if ($request->hasFile($field)) {
                $pathField = $field . '_path';

                if ($specialIssue->{$pathField} && Storage::disk('public')->exists($specialIssue->{$pathField})) {
                    Storage::disk('public')->delete($specialIssue->{$pathField});
                }

                $data[$pathField] = $request->file($field)->store('special-issues/pdfs', 'public');
            }
        }

        $specialIssue->update($data);

        return redirect()
            ->route('admin.special-issues.show', $specialIssue)
            ->with('success', 'Special issue updated successfully.');
    }

    public function destroy(SpecialIssue $specialIssue)
    {
        foreach ($specialIssue->articles as $article) {
            foreach ([$article->final_pdf_path, $article->certificate_path] as $path) {
                if ($path && Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }

        foreach ([$specialIssue->cover_image, $specialIssue->cover_pdf_path, $specialIssue->index_pdf_path, $specialIssue->full_issue_pdf_path] as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $specialIssue->delete();

        return redirect()
            ->route('admin.special-issues.index')
            ->with('success', 'Special issue deleted successfully.');
    }

    private function validatedData(Request $request, ?SpecialIssue $specialIssue = null): array
    {
        return $request->validate([
            'special_issue_id' => 'required|string|max:100|unique:special_issues,special_issue_id,' . ($specialIssue?->id ?? 'NULL'),
            'type' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'institution' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'conference_date' => 'nullable|date',
            'mode' => 'nullable|string|max:100',
            'status' => 'required|in:draft,publication_in_progress,published,archived',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'cover_pdf' => 'nullable|file|mimes:pdf|max:20480',
            'index_pdf' => 'nullable|file|mimes:pdf|max:20480',
            'full_issue_pdf' => 'nullable|file|mimes:pdf|max:51200',
            'about_conference' => 'nullable|string',
            'editorial_details' => 'nullable|string',
        ]);
    }
}
