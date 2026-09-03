@extends('admin.layouts.app')

@section('title', 'Archive')
@section('page-title', 'Archive')

@section('content')
@php
    use App\Support\ArticleHelper;

    $selectedKey = $selectedIssue ? $selectedIssue->volume . '|' . $selectedIssue->number : null;
    $selectedArticleCount = $selectedKey ? $articleCounts->get($selectedKey, 0) : 0;
@endphp

<div class="container-fluid">
    <div class="card">
        <div class="card-header" style="background-color:#00004d; color:white;">
            <h5 class="mb-0">Edit Archive Section</h5>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.archive.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Archive Page Details</h6>

                        <div class="mb-3">
                            <label for="archive_title" class="form-label">Archive Title</label>
                            <input
                                type="text"
                                class="form-control"
                                id="archive_title"
                                name="archive_title"
                                value="{{ old('archive_title', $settings['archive_title']) }}"
                            >
                        </div>

                        <div class="mb-3">
                            <label for="archive_description" class="form-label">Archive Description</label>
                            <textarea
                                class="form-control"
                                id="archive_description"
                                name="archive_description"
                                rows="5"
                            >{{ old('archive_description', $settings['archive_description']) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="archive_issue_select" class="form-label">Select Archive Issue</label>
                            <select id="archive_issue_select" class="form-select">
                                @forelse($archiveIssues as $archiveIssue)
                                    @php
                                        $archiveKey = $archiveIssue->volume . '|' . $archiveIssue->number;
                                        $articleCount = $articleCounts->get($archiveKey, 0);
                                    @endphp
                                    <option value="{{ $archiveIssue->id }}" @selected($selectedIssue && $selectedIssue->id === $archiveIssue->id)>
                                        {{ $archiveIssue->title }} - Volume {{ $archiveIssue->volume }}, Issue {{ $archiveIssue->number }} ({{ $articleCount }} article{{ $articleCount === 1 ? '' : 's' }})
                                    </option>
                                @empty
                                    <option value="">No archive issue found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-primary">Archive Issue Details</h6>

                        <input type="hidden" name="issue_id" value="{{ old('issue_id', $selectedIssue?->id) }}">

                        @if($selectedIssue)
                            <div class="alert alert-light border">
                                Volume {{ $selectedIssue->volume }}, Issue {{ $selectedIssue->number }} has {{ $selectedArticleCount }} article{{ $selectedArticleCount === 1 ? '' : 's' }}.
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="title" class="form-label">Month - Year / Issue Title</label>
                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                name="title"
                                value="{{ old('title', $selectedIssue?->title) }}"
                                placeholder="July-August 2026"
                                required
                            >
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="volume" class="form-label">Volume</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="volume"
                                    name="volume"
                                    value="{{ old('volume', $selectedIssue?->volume) }}"
                                    required
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="number" class="form-label">Issue</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="number"
                                    name="number"
                                    value="{{ old('number', $selectedIssue?->number) }}"
                                    required
                                >
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="year" class="form-label">Year</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="year"
                                    name="year"
                                    value="{{ old('year', $selectedIssue?->year) }}"
                                    placeholder="2026"
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="publish_date" class="form-label">Publish Date</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="publish_date"
                                    name="publish_date"
                                    value="{{ old('publish_date', $selectedIssue?->publish_date) }}"
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="approved_eissn" class="form-label">e-ISSN</label>
                            <input
                                type="text"
                                class="form-control"
                                id="approved_eissn"
                                name="approved_eissn"
                                value="{{ old('approved_eissn', $selectedIssue?->approved_eissn) }}"
                                placeholder="3139-1486"
                            >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="abstract" class="form-label">Issue Description</label>
                        <textarea
                            class="form-control"
                            id="abstract"
                            name="abstract"
                            rows="5"
                        >{{ old('abstract', $selectedIssue?->abstract) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="published_paper_pdf" class="form-label">Full Issue PDF</label>
                            <input type="file" class="form-control" id="published_paper_pdf" name="published_paper_pdf" accept=".pdf">
                            @if($selectedIssue?->published_paper_pdf)
                                <div class="form-text">
                                    Current file:
                                    <a href="{{ route('issues.viewPdf', $selectedIssue) }}" target="_blank" rel="noopener">View PDF</a>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Archive Cover Image</label>
                            <input type="file" class="form-control" id="cover_image" name="cover_image" accept=".jpg,.jpeg,.png,.webp">

                            @if($selectedIssue?->cover_image)
                                <div class="mt-2 d-flex align-items-start gap-3">
                                    <img
                                        src="{{ ArticleHelper::issueCoverUrl($selectedIssue->cover_image) }}"
                                        alt="Current archive cover"
                                        style="width:110px; height:145px; object-fit:contain; border:1px solid #dce5df; border-radius:4px; padding:4px; background:#fbfdfb;"
                                    >
                                    <div>
                                        <small class="text-muted d-block">Current cover is saved for this issue.</small>
                                        <small class="text-muted d-block">Uploading a new cover will replace it on the archive pages.</small>
                                    </div>
                                </div>
                            @else
                                <small class="text-muted d-block mt-2">No archive cover uploaded yet.</small>
                            @endif
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="background-color:#00004d; border:none;">
                    Update Archive Details
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const issueSelect = document.getElementById('archive_issue_select');

        if (!issueSelect) {
            return;
        }

        issueSelect.addEventListener('change', function () {
            if (this.value) {
                window.location.href = "{{ route('admin.archive.edit') }}?issue=" + encodeURIComponent(this.value);
            }
        });
    });
</script>
@endsection
