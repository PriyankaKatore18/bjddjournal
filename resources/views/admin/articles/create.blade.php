@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-center">
  <div style="width:100%; max-width:650px;">

    <h4 class="mb-4 text-center" style="color:#00004d; font-weight:600;">Add Article</h4>

    @if ($errors->any())
      <div class="alert alert-danger mb-4">
          <ul class="mb-0">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.articles.store') }}" 
          style="background:#ffffff; padding:25px; border-radius:10px; box-shadow:0px 4px 12px rgba(0,0,0,0.15);">
      @csrf

      {{-- Title --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
               value="{{ old('title') }}" required maxlength="255">
        @error('title')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Abstract --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Abstract <span class="text-danger">*</span></label>
        <textarea name="abstract" class="form-control @error('abstract') is-invalid @enderror" 
                  rows="4" required>{{ old('abstract') }}</textarea>
        @error('abstract')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Author --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Author <span class="text-danger">*</span></label>
        <select name="author_id" class="form-select @error('author_id') is-invalid @enderror" required>
          <option value="">Select Author</option>
          @foreach($authors as $author)
            <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
              {{ $author->name }}
            </option>
          @endforeach
        </select>
        @error('author_id')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Upload PDF --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Upload PDF <span class="text-danger">*</span></label>
        <input type="file" name="pdf" class="form-control @error('pdf') is-invalid @enderror" 
               accept="application/pdf" required>
        <div class="form-text">Only PDF files are accepted. Maximum file size: 5MB</div>
        @error('pdf')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Status --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
          <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
          <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
          <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
        </select>
        @error('status')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Buttons --}}
      <div class="d-flex gap-2 justify-content-center">
        <button type="submit" class="btn" style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Save</button>
        <a href="{{ route('admin.articles.index') }}" class="btn" style="background-color:#cc7a00; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Cancel</a>
      </div>
    </form>

  </div>
</div>
@endsection