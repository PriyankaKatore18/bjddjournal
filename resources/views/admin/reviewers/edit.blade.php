@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-center">
  <div style="width:100%; max-width:750px;">

    <h4 class="mb-4 text-center" style="color:#00004d; font-weight:600;">Edit Reviewer</h4>

    <form method="POST" action="{{ route('admin.reviewers.update', $reviewer) }}" 
          style="background:#ffffff; padding:25px; border-radius:10px; box-shadow:0px 4px 12px rgba(0,0,0,0.15);">
      @csrf
      @method('PUT')

      {{-- Name --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Name</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name', $reviewer->name) }}">
      </div>

      {{-- Email --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="email" class="form-control" required value="{{ old('email', $reviewer->email) }}">
      </div>

      {{-- Expertise --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Expertise</label>
        <input type="text" name="expertise" class="form-control" value="{{ old('expertise', $reviewer->expertise) }}">
      </div>

      {{-- Affiliation --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Affiliation</label>
        <input type="text" name="affiliation" class="form-control" value="{{ old('affiliation', $reviewer->affiliation) }}">
      </div>

      {{-- Buttons --}}
      <div class="d-flex gap-2 justify-content-center">
        <button class="btn" style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Update Reviewer</button>
        <a href="{{ route('admin.reviewers.index') }}" class="btn" style="background-color:#cc7a00; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Cancel</a>
      </div>
    </form>

  </div>
</div>
@endsection