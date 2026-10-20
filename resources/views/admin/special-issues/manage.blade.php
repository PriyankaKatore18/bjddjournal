@extends('admin.layouts.app')

@section('title', 'Manage Special Issue')
@section('page-title', 'Manage Special Issue')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 gap-3">
    <div>
        <div class="text-muted small">{{ $specialIssue->special_issue_id }}</div>
        <h4 class="mb-1" style="color:#00004d;font-weight:700;">Manage Special Issue</h4>
        <p class="text-muted mb-0">{{ $specialIssue->title }}</p>
    </div>
    <div class="d-flex gap-2">
        @if(in_array($specialIssue->status, ['publication_in_progress', 'published'], true) || $specialIssue->published_articles_count > 0)
            <a href="{{ route('special-issues.show', $specialIssue) }}" target="_blank" class="btn btn-outline-primary"><i class="bi bi-box-arrow-up-right me-1"></i> View Frontend</a>
        @endif
        @if(in_array($specialIssue->status, ['publication_in_progress', 'published'], true))
            <a href="{{ route('special-issues.submit-paper', $specialIssue) }}" target="_blank" class="btn btn-outline-success"><i class="bi bi-file-earmark-text me-1"></i> Submission Form</a>
        @endif
        <a href="{{ route('admin.special-issues.editorial-details.edit', $specialIssue) }}" class="btn btn-outline-primary"><i class="bi bi-people me-1"></i> Editorial Details</a>
        <a href="{{ route('admin.special-issues.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if($errors->any())
    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

@include('admin.special-issues._form', ['specialIssue' => $specialIssue])

<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <div>
            <h5 class="mb-1" style="color:#00004d;">Received Submissions</h5>
            <div class="small text-muted">Papers submitted through this Special Issue's submission form.</div>
        </div>
        <span class="badge bg-info text-dark">{{ $specialIssue->submissions_count }} received</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Paper ID</th><th>Title</th><th>Author</th><th>Submitted</th><th>Status</th><th class="text-end">Action</th></tr></thead>
            <tbody>
                @forelse($submissions as $submission)
                    <tr>
                        <td class="fw-semibold">{{ $submission->paper_id ?: 'N/A' }}</td>
                        <td>{{ $submission->title }}</td>
                        <td>{{ $submission->author_main_name }}</td>
                        <td>{{ optional($submission->submitted_at ?: $submission->created_at)->format('d M Y') }}</td>
                        <td><span class="badge bg-secondary text-capitalize">{{ str_replace('_', ' ', $submission->status) }}</span></td>
                        <td class="text-end"><a href="{{ route('admin.submissions.edit', $submission) }}" class="btn btn-sm btn-outline-primary">Review</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No submissions received for this issue yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($submissions->hasPages())<div class="card-footer bg-white">{{ $submissions->withQueryString()->links() }}</div>@endif
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <div>
            <h5 class="mb-1" style="color:#00004d;">Published Articles</h5>
            <div class="small text-muted">Final, offline-approved papers for this special issue only.</div>
        </div>
        <a href="{{ route('admin.special-issues.articles.create', $specialIssue) }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Add Published Article</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Paper ID</th><th>Article Title</th><th>Author</th><th>Pages</th><th>Status</th><th class="text-end">Action</th></tr></thead>
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
                            <form method="POST" action="{{ route('admin.special-issues.articles.destroy', [$specialIssue, $article]) }}" class="d-inline" onsubmit="return confirm('Delete this published article?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No published articles added yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($articles->hasPages())<div class="card-footer bg-white">{{ $articles->links() }}</div>@endif
</div>
@endsection
