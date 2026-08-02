@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-center">
  <div style="width:100%; max-width:750px;">

    <h4 class="mb-4 text-center" style="color:#00004d; font-weight:600;">Edit Author</h4>

    <form method="POST" action="{{ route('admin.authors.update', $author) }}" 
          style="background:#ffffff; padding:25px; border-radius:10px; box-shadow:0px 4px 12px rgba(0,0,0,0.15);">
      @csrf
      @method('PUT')

      {{-- Name --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Name</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name', $author->name) }}">
      </div>

      {{-- Email --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="email" class="form-control" required value="{{ old('email', $author->email) }}">
      </div>

      {{-- Affiliation --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Affiliation</label>
        <input type="text" name="affiliation" class="form-control" value="{{ old('affiliation', $author->affiliation) }}">
      </div>

      {{-- Phone --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $author->phone) }}">
      </div>

      {{-- Bio --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Bio</label>
        <textarea name="bio" class="form-control" rows="3">{{ old('bio', $author->bio) }}</textarea>
      </div>

      {{-- Buttons --}}
      <div class="d-flex gap-2 justify-content-center">
        <button class="btn" style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Update Author</button>
        <a href="{{ route('admin.authors.index') }}" class="btn" style="background-color:#cc7a00; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Cancel</a>
      </div>
    </form>

  </div>
</div>
@endsection