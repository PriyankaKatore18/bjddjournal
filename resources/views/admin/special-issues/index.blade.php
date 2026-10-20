@extends('admin.layouts.app')

@section('title', 'Special Issues')
@section('page-title', 'Special Issues')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h4 class="mb-1" style="color:#00004d; font-weight:700;">Special Issues</h4>
        <p class="text-muted mb-0">Create and publish conference issues separately from the regular publication workflow.</p>
    </div>
    <a href="{{ route('admin.special-issues.create') }}" class="btn" style="background:#00004d;color:#fff;font-weight:600;">
        <i class="bi bi-plus-lg me-1"></i> Add Special Issue
    </a>
</div>

<div class="alert alert-info border-0">
    <strong>Developer scope:</strong> paper checking, AI assessment, peer review, copyright verification and acceptance are handled offline. Only final approved articles should be added here.
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead style="background:#00004d;color:#fff;">
                <tr>
                    <th>Special Issue</th>
                    <th>Institution</th>
                    <th>Conference</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Submissions / Articles</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($specialIssues as $specialIssue)
                    @php
                        $statusLabel = str_replace('_', ' ', $specialIssue->status);
                        $statusClass = match ($specialIssue->status) {
                            'published' => 'bg-success',
                            'publication_in_progress' => 'bg-warning text-dark',
                            'archived' => 'bg-secondary',
                            default => 'bg-light text-dark border',
                        };
                    @endphp
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $specialIssue->title }}</div>
                            <div class="small text-muted">{{ $specialIssue->special_issue_id }}</div>
                            @if($specialIssue->subtitle)<div class="small text-muted">{{ $specialIssue->subtitle }}</div>@endif
                        </td>
                        <td>{{ $specialIssue->institution ?: '—' }}</td>
                        <td>{{ $specialIssue->type }}</td>
                        <td>{{ $specialIssue->conference_date?->format('d M Y') ?: '—' }}</td>
                        <td><span class="badge {{ $statusClass }} text-capitalize">{{ $statusLabel }}</span></td>
                        <td>{{ $specialIssue->submissions_count }} received<br><span class="text-muted">{{ $specialIssue->published_articles_count }} published / {{ $specialIssue->articles_count }} total</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.special-issues.show', $specialIssue) }}" class="btn btn-sm btn-primary">Manage</a>
                            <a href="{{ route('admin.special-issues.edit', $specialIssue) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @if(in_array($specialIssue->status, ['publication_in_progress', 'published'], true) || $specialIssue->published_articles_count > 0)
                                <a href="{{ route('special-issues.show', $specialIssue) }}" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
                            @endif
                            <form method="POST" action="{{ route('admin.special-issues.destroy', $specialIssue) }}" class="d-inline" onsubmit="return confirm('Delete this special issue and all of its articles?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-5">No special issues created yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($specialIssues->hasPages())
    <div class="mt-4">{{ $specialIssues->links() }}</div>
@endif
@endsection
