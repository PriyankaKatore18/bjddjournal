@extends('admin.layouts.app')

@section('title', 'Add Author')
@section('content')
<div class="d-flex justify-content-center">
  <div style="width:100%; max-width:700px;">

    <h4 class="mb-4 text-center" style="color:#00004d; font-weight:600;">Add Author</h4>

    <form method="POST" action="{{ route('admin.authors.store') }}" 
          style="background:#ffffff; padding:25px; border-radius:10px; box-shadow:0px 4px 12px rgba(0,0,0,0.15);">
      @csrf

      <div class="mb-3">
        <label class="form-label fw-semibold">Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Affiliation</label>
        <input type="text" name="affiliation" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Phone</label>
        <input type="text" 
               name="phone" 
               class="form-control" 
               maxlength="10" 
               pattern="\d{10}" 
               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);" 
               {{-- placeholder="Enter 10-digit phone number"  --}}
               required>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Bio</label>
        <textarea name="bio" class="form-control" rows="3"></textarea>
      </div>

      <div class="d-flex gap-2 justify-content-center">
        <button class="btn" style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Save Author</button>
        <a href="{{ route('admin.authors.index') }}" class="btn" style="background-color:#cc7a00; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Cancel</a>
      </div>
    </form>

  </div>
</div>
@endsection
