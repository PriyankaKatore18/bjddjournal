@php
    $record = $article ?? null;
    $isEdit = $record && $record->exists;
    $formAction = $isEdit
        ? route('admin.special-issues.articles.update', [$specialIssue, $record])
        : route('admin.special-issues.articles.store', $specialIssue);
@endphp

<form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="alert alert-warning border-0 small">
        Add a paper here only after offline plagiarism check, AI assessment, peer review, copyright process and final acceptance are complete.
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label fw-semibold">Special Issue</label>
            <input type="text" class="form-control" value="{{ $specialIssue->title }}" disabled>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Paper ID <span class="text-danger">*</span></label>
            <input type="text" name="paper_id" class="form-control" value="{{ old('paper_id', $record?->paper_id) }}" required>
            @error('paper_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-2">
            <label class="form-label fw-semibold">Display Order <span class="text-danger">*</span></label>
            <input type="number" name="display_order" class="form-control" min="1" max="9999" value="{{ old('display_order', $record?->display_order ?? ($nextDisplayOrder ?? 1)) }}" required>
            <div class="form-text">1 = first article</div>
            @error('display_order')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label fw-semibold">Article Title <span class="text-danger">*</span></label>
            <input type="text" name="article_title" class="form-control" placeholder="Enter final article title" value="{{ old('article_title', $record?->article_title) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Article Type <span class="text-danger">*</span></label>
            <input type="text" name="article_type" class="form-control" placeholder="Research Article" value="{{ old('article_type', $record?->article_type ?? 'Research Article') }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Publisher <span class="text-danger">*</span></label>
            <input type="text" name="publisher" class="form-control" placeholder="Eagle Leap Publication" value="{{ old('publisher', $record?->publisher ?? 'Eagle Leap Publication') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Language <span class="text-danger">*</span></label>
            <select name="language" class="form-select" required>
                @foreach(['English', 'Hindi', 'Marathi'] as $language)
                    <option value="{{ $language }}" @selected(old('language', $record?->language ?? 'English') === $language)>{{ $language }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-8">
            <label class="form-label fw-semibold">Main Author <span class="text-danger">*</span></label>
            <input type="text" name="main_author" class="form-control" placeholder="Enter main author" value="{{ old('main_author', $record?->main_author) }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Co-Authors</label>
            <input type="text" name="co_authors" class="form-control" placeholder="Enter co-author(s)" value="{{ old('co_authors', $record?->co_authors) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Affiliation</label>
            <input type="text" name="affiliation" class="form-control" placeholder="Institution / Department" value="{{ old('affiliation', $record?->affiliation) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Country</label>
            <input type="text" name="country" class="form-control" value="{{ old('country', $record?->country ?? 'India') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Pages</label>
            <input type="text" name="pages" class="form-control" placeholder="1-12" value="{{ old('pages', $record?->pages) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Published Date</label>
            <input type="date" name="published_date" class="form-control" value="{{ old('published_date', $record?->published_date?->format('Y-m-d')) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">DOI</label>
            <input type="text" name="doi" class="form-control" placeholder="10.5281/zenodo.xxxxxxxx" value="{{ old('doi', $record?->doi) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">eISSN</label>
            <input type="text" name="eissn" class="form-control" value="{{ old('eissn', $record?->eissn ?? '3139-1486') }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Final PDF {{ !$isEdit ? '*' : '' }}</label>
            <input type="file" name="final_pdf" class="form-control" accept=".pdf">
            @if($record?->final_pdf_path)<div class="small text-muted mt-1">Final PDF already uploaded. Upload to replace it.</div>@endif
            @error('final_pdf')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Certificate {{ !$isEdit ? '*' : '' }}</label>
            <input type="file" name="certificate" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
            @if($record?->certificate_path)<div class="small text-muted mt-1">Certificate already uploaded. Upload to replace it.</div>@endif
            @error('certificate')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label fw-semibold">Abstract</label>
            <textarea name="abstract" class="form-control" rows="6" placeholder="Enter / paste final abstract...">{{ old('abstract', $record?->abstract) }}</textarea>
        </div>
        <div class="col-12">
            <label class="form-label fw-semibold">Keywords</label>
            <input type="text" name="keywords" class="form-control" placeholder="Keyword 1, Keyword 2, Keyword 3..." value="{{ old('keywords', $record?->keywords) }}">
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2 mt-4">
        <button type="submit" name="action" value="draft" class="btn btn-outline-secondary">Save Draft</button>
        <button type="submit" name="action" value="publish" class="btn btn-primary">{{ $isEdit && $record->status === 'published' ? 'Update Published Article' : 'Publish Article' }}</button>
        <a href="{{ route('admin.special-issues.articles.index', $specialIssue) }}" class="btn btn-link">Cancel</a>
    </div>
</form>
