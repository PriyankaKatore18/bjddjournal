<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialIssue;
use App\Models\SpecialIssueArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SpecialIssueArticleController extends Controller
{
    public function index(SpecialIssue $specialIssue)
    {
        $articles = $specialIssue->articles()
            ->orderBy('display_order')
            ->orderBy('id')
            ->paginate(10);

        return view('admin.special-issues.articles.index', compact('specialIssue', 'articles'));
    }

    public function create(SpecialIssue $specialIssue)
    {
        $nextDisplayOrder = ((int) $specialIssue->articles()->max('display_order')) + 1;

        return view('admin.special-issues.articles.create', compact('specialIssue', 'nextDisplayOrder'));
    }

    public function store(Request $request, SpecialIssue $specialIssue)
    {
        $action = $this->action($request);
        $data = $this->validatedData($request);

        if ($action === 'publish') {
            $this->requirePublicationFiles($request);
        }

        $data['special_issue_id'] = $specialIssue->id;
        $data['status'] = $action === 'publish' ? 'published' : 'draft';
        $this->storeFiles($request, $data);

        SpecialIssueArticle::create($data);

        if ($action === 'publish' && $specialIssue->status === 'draft') {
            $specialIssue->update(['status' => 'publication_in_progress']);
        }

        return redirect()
            ->route('admin.special-issues.articles.index', $specialIssue)
            ->with('success', $action === 'publish' ? 'Article published successfully.' : 'Article saved as draft.');
    }

    public function show(SpecialIssue $specialIssue, SpecialIssueArticle $article)
    {
        $this->ensureBelongsTo($specialIssue, $article);

        return redirect()->route('special-issues.articles.show', [$specialIssue, $article]);
    }

    public function edit(SpecialIssue $specialIssue, SpecialIssueArticle $article)
    {
        $this->ensureBelongsTo($specialIssue, $article);

        return view('admin.special-issues.articles.edit', compact('specialIssue', 'article'));
    }

    public function update(Request $request, SpecialIssue $specialIssue, SpecialIssueArticle $article)
    {
        $this->ensureBelongsTo($specialIssue, $article);

        $action = $this->action($request);
        $data = $this->validatedData($request, $article);

        if ($action === 'publish' && ! $article->final_pdf_path && ! $request->hasFile('final_pdf')) {
            throw ValidationException::withMessages(['final_pdf' => 'A final PDF is required before publishing this article.']);
        }

        if ($action === 'publish' && ! $article->certificate_path && ! $request->hasFile('certificate')) {
            throw ValidationException::withMessages(['certificate' => 'A certificate is required before publishing this article.']);
        }

        $data['status'] = $action === 'publish' ? 'published' : 'draft';
        $this->replaceFiles($request, $article, $data);
        $article->update($data);

        if ($action === 'publish' && $specialIssue->status === 'draft') {
            $specialIssue->update(['status' => 'publication_in_progress']);
        }

        return redirect()
            ->route('admin.special-issues.articles.index', $specialIssue)
            ->with('success', $action === 'publish' ? 'Article published successfully.' : 'Article saved as draft.');
    }

    public function destroy(SpecialIssue $specialIssue, SpecialIssueArticle $article)
    {
        $this->ensureBelongsTo($specialIssue, $article);

        foreach ([$article->final_pdf_path, $article->certificate_path] as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $article->delete();

        return redirect()
            ->route('admin.special-issues.articles.index', $specialIssue)
            ->with('success', 'Published article deleted successfully.');
    }

    private function validatedData(Request $request, ?SpecialIssueArticle $article = null): array
    {
        return $request->validate([
            'paper_id' => 'required|string|max:120|unique:special_issue_articles,paper_id,' . ($article?->id ?? 'NULL'),
            'display_order' => 'required|integer|min:1|max:9999',
            'article_title' => 'required|string|max:255',
            'article_type' => 'required|string|max:100',
            'language' => 'required|string|max:100',
            'main_author' => 'required|string|max:255',
            'co_authors' => 'nullable|string',
            'affiliation' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'pages' => 'nullable|string|max:50',
            'published_date' => 'nullable|date',
            'doi' => 'nullable|string|max:255',
            'eissn' => 'nullable|string|max:100',
            'publisher' => 'required|string|max:255',
            'final_pdf' => 'nullable|file|mimes:pdf|max:20480',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'abstract' => 'nullable|string',
            'keywords' => 'nullable|string',
        ]);
    }

    private function action(Request $request): string
    {
        return $request->input('action') === 'publish' ? 'publish' : 'draft';
    }

    private function requirePublicationFiles(Request $request): void
    {
        $request->validate([
            'final_pdf' => 'required|file|mimes:pdf|max:20480',
            'certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);
    }

    private function storeFiles(Request $request, array &$data): void
    {
        if ($request->hasFile('final_pdf')) {
            $data['final_pdf_path'] = $request->file('final_pdf')->store('special-issues/articles', 'public');
        }

        if ($request->hasFile('certificate')) {
            $data['certificate_path'] = $request->file('certificate')->store('special-issues/certificates', 'public');
        }
    }

    private function replaceFiles(Request $request, SpecialIssueArticle $article, array &$data): void
    {
        if ($request->hasFile('final_pdf')) {
            if ($article->final_pdf_path && Storage::disk('public')->exists($article->final_pdf_path)) {
                Storage::disk('public')->delete($article->final_pdf_path);
            }

            $data['final_pdf_path'] = $request->file('final_pdf')->store('special-issues/articles', 'public');
        }

        if ($request->hasFile('certificate')) {
            if ($article->certificate_path && Storage::disk('public')->exists($article->certificate_path)) {
                Storage::disk('public')->delete($article->certificate_path);
            }

            $data['certificate_path'] = $request->file('certificate')->store('special-issues/certificates', 'public');
        }
    }

    private function ensureBelongsTo(SpecialIssue $specialIssue, SpecialIssueArticle $article): void
    {
        abort_unless($article->special_issue_id === $specialIssue->id, 404);
    }
}
