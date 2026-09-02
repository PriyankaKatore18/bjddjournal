<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticlesController extends Controller
{
    public function index()
    {
        // Use paginate instead of get() for pagination
        $articles = Articles::with('author')->latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $authors = Author::all();
        return view('admin.articles.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'abstract'  => 'required|string',
            'author_id' => 'required|exists:authors,id',
            'status'    => 'required|in:submitted,under_review,accepted,rejected,published',
            'pdf'       => 'required|mimes:pdf|max:5120', // 5MB max
        ], [
            'title.required' => 'The title field is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'abstract.required' => 'The abstract field is required.',
            'author_id.required' => 'Please select an author.',
            'author_id.exists' => 'The selected author is invalid.',
            'status.required' => 'Please select a status.',
            'status.in' => 'The selected status is invalid.',
            'pdf.required' => 'Please upload a PDF file.',
            'pdf.mimes' => 'The file must be a PDF.',
            'pdf.max' => 'The PDF may not be greater than 5MB.',
        ]);

        $data = $request->only(['title', 'abstract', 'author_id', 'status']);

        if ($request->hasFile('pdf')) {
            $data['pdf_path'] = $request->file('pdf')->store('articles', 'public');
        }

        Articles::create($data);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article created successfully.');
    }

    public function edit(Articles $article)
    {
        $authors = Author::all();
        return view('admin.articles.edit', compact('article', 'authors'));
    }

    public function update(Request $request, Articles $article)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'abstract'  => 'required|string',
            'author_id' => 'required|exists:authors,id',
            'status'    => 'required|in:submitted,under_review,accepted,rejected,published',
            'pdf'       => 'nullable|mimes:pdf|max:5120', // 5MB max
        ], [
            'title.required' => 'The title field is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'abstract.required' => 'The abstract field is required.',
            'author_id.required' => 'Please select an author.',
            'author_id.exists' => 'The selected author is invalid.',
            'status.required' => 'Please select a status.',
            'status.in' => 'The selected status is invalid.',
            'pdf.mimes' => 'The file must be a PDF.',
            'pdf.max' => 'The PDF may not be greater than 5MB.',
        ]);

        $data = $request->only(['title', 'abstract', 'author_id', 'status']);

        if ($request->hasFile('pdf')) {
            // Delete old PDF if exists
            if ($article->pdf_path && Storage::disk('public')->exists($article->pdf_path)) {
                Storage::disk('public')->delete($article->pdf_path);
            }
            
            $data['pdf_path'] = $request->file('pdf')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article updated successfully.');
    }

    public function destroy(Articles $article)
    {
        // Delete associated PDF file
        if ($article->pdf_path && Storage::disk('public')->exists($article->pdf_path)) {
            Storage::disk('public')->delete($article->pdf_path);
        }
        
        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }
}