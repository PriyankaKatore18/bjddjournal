@extends('admin.layouts.app')

@section('title', 'Edit Index Partner')
@section('content')

<div class="d-flex justify-content-center">
  <div style="width:100%; max-width:750px;">
    <h4 class="mb-4 text-center" style="color:#00004d; font-weight:600;">Edit Index Partner</h4>

    <form method="POST"
      action="{{ route('admin.index-partners.update', $partner->id) }}"
      enctype="multipart/form-data"
      style="background:#ffffff; padding:25px; border-radius:10px; box-shadow:0px 4px 12px rgba(0,0,0,0.15);">

      @csrf

      <div class="mb-3">
        <label class="form-label fw-semibold">Name</label>
        <input type="text"
          name="name"
          class="form-control"
          value="{{ old('name', $partner->name) }}"
          placeholder="Enter Partner Name">
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Icon</label>

        @if($partner->icon)
        <div class="mb-2">
          <img src="{{ asset('storage/app/public/' . $partner->icon) }}"
            alt="Partner Icon"
            style="width:80px; height:80px; object-fit:contain; border-radius:6px;">
        </div>
        @endif

        <input type="file" name="icon" class="form-control" accept=".jpg,.jpeg,.png">
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">URL</label>
        <input type="text"
          name="url"
          class="form-control"
          value="{{ old('url', $partner->url) }}"
          placeholder="Enter URL">
      </div>

      <div class="d-flex gap-2 justify-content-center">
        <button class="btn"
          style="background-color:#27b71f; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">
          Update Partner
        </button>

        <a href="{{ route('admin.index-partners.index') }}"
          class="btn"
          style="background-color:#cc7a00; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">
          Cancel
        </a>
      </div>

    </form>
  </div>
</div>

@endsection