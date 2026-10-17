@php
    $issue = $specialIssue ?? null;
    $isEdit = $issue && $issue->exists;
    $formAction = $isEdit ? route('admin.special-issues.update', $issue) : route('admin.special-issues.store');
@endphp

<form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="alert alert-info border-0 small">
        This module is for creating and publishing Special Issues / Conference Issues. All paper checking and approval happens offline.
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label fw-semibold">Special Issue ID <span class="text-danger">*</span></label>
            <input type="text" name="special_issue_id" class="form-control" value="{{ old('special_issue_id', $issue?->special_issue_id ?? ($suggestedId ?? '')) }}" required>
            @error('special_issue_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
            <input type="text" name="type" class="form-control" value="{{ old('type', $issue?->type ?? 'Conference Special Issue') }}" required>
        </div>
        <div class="col-md-8">
            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $issue?->title) }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select" required>
                @foreach(['draft' => 'Draft', 'publication_in_progress' => 'Publication in Progress', 'published' => 'Published', 'archived' => 'Archived'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $issue?->status ?? 'draft') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label class="form-label fw-semibold">Subtitle</label>
            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $issue?->subtitle) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Institution</label>
            <input type="text" name="institution" class="form-control" value="{{ old('institution', $issue?->institution) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Department</label>
            <input type="text" name="department" class="form-control" value="{{ old('department', $issue?->department) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Conference Date</label>
            <input type="date" name="conference_date" class="form-control" value="{{ old('conference_date', $issue?->conference_date?->format('Y-m-d')) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Mode</label>
            <input type="text" name="mode" class="form-control" placeholder="Online / Offline / Hybrid" value="{{ old('mode', $issue?->mode) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Cover / Banner</label>
            <input type="file" name="cover_image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
            @if($issue?->cover_image)
                <div class="small text-muted mt-2">A cover is already uploaded. Upload a new image to replace it.</div>
            @endif
        </div>
        <div class="col-md-6 d-flex align-items-end">
            @if($issue?->cover_image)
                <img src="{{ asset('storage/' . ltrim($issue->cover_image, '/')) }}" alt="Special issue cover" style="max-height:100px;max-width:180px;object-fit:cover;border-radius:6px;">
            @endif
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Cover PDF</label>
            <input type="file" name="cover_pdf" class="form-control" accept=".pdf">
            @if($issue?->cover_pdf_path)<div class="small text-muted mt-2">Cover PDF already uploaded. Upload a new PDF to replace it.</div>@endif
            @error('cover_pdf')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Index PDF</label>
            <input type="file" name="index_pdf" class="form-control" accept=".pdf">
            @if($issue?->index_pdf_path)<div class="small text-muted mt-2">Index PDF already uploaded. Upload a new PDF to replace it.</div>@endif
            @error('index_pdf')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Full Issue PDF</label>
            <input type="file" name="full_issue_pdf" class="form-control" accept=".pdf">
            @if($issue?->full_issue_pdf_path)<div class="small text-muted mt-2">Full Issue PDF already uploaded. Upload a new PDF to replace it.</div>@endif
            @error('full_issue_pdf')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label fw-semibold">About Conference</label>
            <textarea name="about_conference" class="form-control" rows="6" placeholder="Conference description, objective and publication note...">{{ old('about_conference', $issue?->about_conference) }}</textarea>
        </div>
    </div>

    <div class="d-flex gap-2 mt-4">
        <button class="btn btn-primary">{{ $isEdit ? 'Save Changes' : 'Create Special Issue' }}</button>
        <a href="{{ $isEdit ? route('admin.special-issues.show', $issue) : route('admin.special-issues.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</form>
