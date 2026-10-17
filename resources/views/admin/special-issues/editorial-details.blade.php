@extends('admin.layouts.app')

@section('title', 'Editorial / Conference Details')
@section('page-title', 'Editorial / Conference Details')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 gap-3">
    <div>
        <div class="text-muted small">{{ $specialIssue->special_issue_id }}</div>
        <h4 class="mb-1" style="color:#00004d;font-weight:700;">Editorial / Conference Details</h4>
        <p class="text-muted mb-0">{{ $specialIssue->title }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.special-issues.show', $specialIssue) }}" class="btn btn-outline-secondary">Back to Special Issue</a>
        @if(in_array($specialIssue->status, ['publication_in_progress', 'published'], true) || $specialIssue->publishedArticles()->exists())
            <a href="{{ route('special-issues.show', $specialIssue) }}" target="_blank" class="btn btn-outline-primary">View Frontend</a>
        @endif
    </div>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if($errors->any())
    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<form method="POST" action="{{ route('admin.special-issues.editorial-details.update', $specialIssue) }}" class="card border-0 shadow-sm p-4 mb-4">
    @csrf @method('PUT')
    <h5 style="color:#00004d;">Conference / Editorial Note</h5>
    <p class="small text-muted">Add the editorial note, committee information, conference description or publication note.</p>
    <textarea name="editorial_details" class="form-control" rows="6" placeholder="Editorial note, committee or conference details...">{{ old('editorial_details', $specialIssue->editorial_details) }}</textarea>
    <div class="mt-3"><button class="btn btn-primary">Save Details</button></div>
</form>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-1" style="color:#00004d;">Add Editorial / Conference Member</h5>
        <div class="small text-muted">The display order controls the order of these cards on the frontend.</div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.special-issues.editorial-details.editors.store', $specialIssue) }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Editor Name <span class="text-danger">*</span></label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Position</label><input type="text" name="position" class="form-control" placeholder="Editor-in-Chief / Chair / Coordinator" value="{{ old('position') }}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Department</label><input type="text" name="department" class="form-control" value="{{ old('department') }}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Institution</label><input type="text" name="institution" class="form-control" value="{{ old('institution') }}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Photo</label><input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.webp"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Card Order <span class="text-danger">*</span></label><input type="number" name="display_order" class="form-control" min="0" value="{{ old('display_order', ($specialIssue->editors->max('display_order') ?? -1) + 1) }}" required><div class="form-text">Lower numbers appear first.</div></div>
            </div>
            <button class="btn btn-primary mt-4">Add Member</button>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3"><h5 class="mb-0" style="color:#00004d;">Editorial / Conference Members</h5></div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Order</th><th>Editor</th><th>Position</th><th>Department</th><th>Institution</th><th>Photo</th><th class="text-end">Action</th></tr></thead>
            <tbody>
                @forelse($specialIssue->editors as $editor)
                    <tr>
                        <td class="fw-semibold">{{ $editor->display_order }}</td>
                        <td>{{ $editor->name }}</td>
                        <td>{{ $editor->position ?: '—' }}</td>
                        <td>{{ $editor->department ?: '—' }}</td>
                        <td>{{ $editor->institution ?: '—' }}</td>
                        <td>@if($editor->photo)<img src="{{ asset('storage/' . ltrim($editor->photo, '/')) }}" alt="{{ $editor->name }}" style="width:44px;height:44px;object-fit:cover;border-radius:50%;">@else<span class="text-muted">—</span>@endif</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.special-issues.editorial-details.editors.edit', [$specialIssue, $editor]) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.special-issues.editorial-details.editors.destroy', [$specialIssue, $editor]) }}" class="d-inline" onsubmit="return confirm('Delete this editorial member?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No editorial / conference members added yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
