@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-center">
  <div style="width:100%; max-width:750px;">

    <h4 class="mb-4 text-center" style="color:#00004d; font-weight:600;">Edit Article</h4>

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.articles.update', $article) }}" 
          style="background:#ffffff; padding:25px; border-radius:10px; box-shadow:0px 4px 12px rgba(0,0,0,0.15);">
      @csrf
      @method('PUT')

      {{-- Title --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control" required value="{{ old('title', $article->title) }}">
      </div>

      {{-- Abstract --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Abstract <span class="text-danger">*</span></label>
        <textarea name="abstract" class="form-control" rows="3" required>{{ old('abstract', $article->abstract) }}</textarea>
      </div>

      {{-- Author --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Author <span class="text-danger">*</span></label>
        <select name="author_id" class="form-select" required>
          @foreach($authors as $author)
            <option value="{{ $author->id }}" {{ $article->author_id == $author->id ? 'selected' : '' }}>
              {{ $author->name }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Upload PDF --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Upload PDF</label>
        <input type="file" name="pdf" class="form-control" accept="application/pdf">
        @if($article->pdf_path)
          <div class="mt-2">
            <a href="{{ asset('storage/'.$article->pdf_path) }}" target="_blank" class="text-primary">View Current PDF</a>
          </div>
        @endif
      </div>

      {{-- Status --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select" required>
          <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Draft</option>
          <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Published</option>
          <option value="archived" {{ $article->status == 'archived' ? 'selected' : '' }}>Archived</option>
        </select>
      </div>

      {{-- Buttons --}}
      <div class="d-flex gap-2 justify-content-center">
        <button class="btn" style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Update Article</button>
        <a href="{{ route('admin.articles.index') }}" class="btn" style="background-color:#cc7a00; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Cancel</a>
      </div>
    </form>

  </div>
</div>
@endsection