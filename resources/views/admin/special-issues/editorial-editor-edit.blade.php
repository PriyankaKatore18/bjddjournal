@extends('admin.layouts.app')

@section('title', 'Edit Editorial Member')
@section('page-title', 'Edit Editorial Member')

@section('content')
<div class="mb-4">
    <div class="text-muted small">{{ $specialIssue->special_issue_id }}</div>
    <h4 style="color:#00004d;font-weight:700;">Edit Editorial / Conference Member</h4>
    <p class="text-muted mb-0">{{ $specialIssue->title }}</p>
</div>

@if($errors->any())
    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<form method="POST" action="{{ route('admin.special-issues.editorial-details.editors.update', [$specialIssue, $editor]) }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4">
    @csrf @method('PUT')
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label fw-semibold">Editor Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name', $editor->name) }}" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Position</label><input type="text" name="position" class="form-control" value="{{ old('position', $editor->position) }}"></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Department</label><input type="text" name="department" class="form-control" value="{{ old('department', $editor->department) }}"></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Institution</label><input type="text" name="institution" class="form-control" value="{{ old('institution', $editor->institution) }}"></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Photo</label><input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.webp">@if($editor->photo)<div class="small text-muted mt-1">Upload a new photo to replace the current one.</div>@endif</div>
        <div class="col-md-6"><label class="form-label fw-semibold">Card Order <span class="text-danger">*</span></label><input type="number" name="display_order" class="form-control" min="0" value="{{ old('display_order', $editor->display_order) }}" required><div class="form-text">Lower numbers appear first.</div></div>
    </div>
    <div class="d-flex gap-2 mt-4"><button class="btn btn-primary">Save Member</button><a href="{{ route('admin.special-issues.editorial-details.edit', $specialIssue) }}" class="btn btn-outline-secondary">Cancel</a></div>
</form>
@endsection
