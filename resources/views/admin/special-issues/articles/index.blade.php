@extends('admin.layouts.app')

@section('title', 'Published Articles')
@section('page-title', 'Published Articles')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 gap-3">
    <div>
        <div class="text-muted small">{{ $specialIssue->special_issue_id }}</div>
        <h4 class="mb-1" style="color:#00004d;font-weight:700;">Published Articles</h4>
        <p class="text-muted mb-0">{{ $specialIssue->title }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.special-issues.articles.create', $specialIssue) }}" class="btn btn-primary">+ Add Published Article</a>
        <a href="{{ route('admin.special-issues.show', $specialIssue) }}" class="btn btn-outline-secondary">Manage Issue</a>
    </div>
</div>

<div class="alert alert-info border-0">Only final, offline-approved papers belong in this list. These articles are visible only under this Special Issue / Conference Issue.</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background:#00004d;color:#fff;"><tr><th>Paper ID</th><th>Article Title</th><th>Author</th><th>Pages</th><th>Status</th><th class="text-end">Action</th></tr></thead>
            <tbody>
                @forelse($articles as $article)
                    <tr>
                        <td class="fw-semibold">{{ $article->paper_id }}</td>
                        <td>{{ $article->article_title }}</td>
                        <td>{{ $article->main_author }}</td>
                        <td>{{ $article->pages ?: '—' }}</td>
                        <td><span class="badge {{ $article->status === 'published' ? 'bg-success' : 'bg-secondary' }} text-capitalize">{{ $article->status }}</span></td>
                        <td class="text-end text-nowrap">
                            @if($article->status === 'published')<a href="{{ route('special-issues.articles.show', [$specialIssue, $article]) }}" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>@endif
                            <a href="{{ route('admin.special-issues.articles.edit', [$specialIssue, $article]) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.special-issues.articles.destroy', [$specialIssue, $article]) }}" class="d-inline" onsubmit="return confirm('Delete this article?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">No articles have been added for this special issue.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@if($articles->hasPages())<div class="mt-4">{{ $articles->links() }}</div>@endif
@endsection
