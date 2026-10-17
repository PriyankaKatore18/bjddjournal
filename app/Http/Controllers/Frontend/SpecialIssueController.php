<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SpecialIssue;
use App\Models\SpecialIssueArticle;
use Illuminate\Support\Facades\Storage;

class SpecialIssueController extends Controller
{
    public function index()
    {
        $specialIssues = SpecialIssue::query()
            ->where(function ($query) {
                $query->whereIn('status', ['publication_in_progress', 'published'])
                    ->orWhereHas('publishedArticles');
            })
            ->withCount('publishedArticles')
            ->latest()
            ->paginate(12);

        return view('special-issues.index', compact('specialIssues'));
    }

    public function show(SpecialIssue $specialIssue)
    {
        $isVisible = in_array($specialIssue->status, ['publication_in_progress', 'published'], true)
            || $specialIssue->publishedArticles()->exists();

        abort_unless($isVisible, 404);
        $specialIssue->load('editors');

        $articles = $specialIssue->publishedArticles()->latest('published_date')->latest()->paginate(12);

        return view('special-issues.show', compact('specialIssue', 'articles'));
    }

    public function downloadCover(SpecialIssue $specialIssue)
    {
        return $this->downloadIssueFile($specialIssue, 'cover_pdf_path', 'cover.pdf');
    }

    public function downloadIndex(SpecialIssue $specialIssue)
    {
        return $this->downloadIssueFile($specialIssue, 'index_pdf_path', 'index.pdf');
    }

    public function downloadFullIssue(SpecialIssue $specialIssue)
    {
        return $this->downloadIssueFile($specialIssue, 'full_issue_pdf_path', 'full-issue.pdf');
    }

    public function article(SpecialIssue $specialIssue, SpecialIssueArticle $article)
    {
        abort_unless($article->special_issue_id === $specialIssue->id && $article->status === 'published', 404);

        $article->increment('view_count');

        return view('special-issues.article', compact('specialIssue', 'article'));
    }

    public function pdf(SpecialIssue $specialIssue, SpecialIssueArticle $article)
    {
        $this->ensurePublishedArticle($specialIssue, $article);
        abort_unless($article->final_pdf_path && Storage::disk('public')->exists($article->final_pdf_path), 404);

        $article->increment('download_count');

        return response()->file(Storage::disk('public')->path($article->final_pdf_path));
    }

    public function certificate(SpecialIssue $specialIssue, SpecialIssueArticle $article)
    {
        $this->ensurePublishedArticle($specialIssue, $article);
        abort_unless($article->certificate_path && Storage::disk('public')->exists($article->certificate_path), 404);

        return response()->file(Storage::disk('public')->path($article->certificate_path));
    }

    private function ensurePublishedArticle(SpecialIssue $specialIssue, SpecialIssueArticle $article): void
    {
        abort_unless(
            $article->special_issue_id === $specialIssue->id
                && $article->status === 'published'
                && in_array($specialIssue->status, ['publication_in_progress', 'published'], true),
            404
        );
    }

    private function downloadIssueFile(SpecialIssue $specialIssue, string $column, string $filename)
    {
        $isVisible = in_array($specialIssue->status, ['publication_in_progress', 'published'], true)
            || $specialIssue->publishedArticles()->exists();

        abort_unless($isVisible, 404);

        $path = $specialIssue->{$column};
        abort_unless($path && Storage::disk('public')->exists($path), 404);

        return Storage::disk('public')->download($path, $filename);
    }
}
