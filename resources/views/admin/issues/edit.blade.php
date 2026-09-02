@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-center">
  <div style="width:100%; max-width:750px;">
    <h4 class="mb-4 text-center" style="color:#00004d; font-weight:600;">Edit Issue</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.issues.update', $issue) }}" enctype="multipart/form-data"
          style="background:#ffffff; padding:25px; border-radius:10px; box-shadow:0px 4px 12px rgba(0,0,0,0.15);">
      @csrf
      @method('PUT')

      {{-- Title --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control" required value="{{ old('title', $issue->title) }}">
      </div>

      {{-- Abstract --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Abstract</label>
        <textarea name="abstract" class="form-control" rows="4" placeholder="Enter paper abstract">{{ old('abstract', $issue->abstract) }}</textarea>
      </div>

      <div class="row">
        {{-- Volume --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Volume <span class="text-danger">*</span></label>
          <input type="text" name="volume" class="form-control" required value="{{ old('volume', $issue->volume) }}">
        </div>

        {{-- Number --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Number <span class="text-danger">*</span></label>
          <input type="text" name="number" class="form-control" required value="{{ old('number', $issue->number) }}">
        </div>
      </div>

      <div class="row">
        {{-- Publish Date --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Publish Date <span class="text-danger">*</span></label>
          <input type="date" name="publish_date" class="form-control" required value="{{ old('publish_date', $issue->publish_date) }}">
        </div>

        {{-- Registration ID --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Registration ID</label>
          <input type="text" name="registration_id" class="form-control" value="{{ old('registration_id', $issue->registration_id) }}">
        </div>
      </div>

      <div class="row">
        {{-- Published Paper ID --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Published Paper ID</label>
          <input type="text" name="published_paper_id" class="form-control" value="{{ old('published_paper_id', $issue->published_paper_id) }}">
        </div>

        {{-- Year --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Year <span class="text-danger">*</span></label>
          <input type="text" name="year" class="form-control" required value="{{ old('year', $issue->year) }}">
        </div>
      </div>

      <div class="row">
        {{-- Approved eISSN --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Approved eISSN</label>
          <input type="text" name="approved_eissn" class="form-control" value="{{ old('approved_eissn', $issue->approved_eissn) }}">
        </div>

        {{-- Country --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Country</label>
          <input type="text" name="country" class="form-control" value="{{ old('country', $issue->country) }}">
        </div>
      </div>

      <div class="row">
        {{-- CrossRef DOI Member ID --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">DOI </label>
          <input type="text" name="crossref_doi_member_id" class="form-control" value="{{ old('crossref_doi_member_id', $issue->crossref_doi_member_id) }}">
        </div>

        {{-- Page No --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Page No</label>
          <input type="text" name="page_no" class="form-control" value="{{ old('page_no', $issue->page_no) }}">
        </div>
      </div>

      <div class="row">
        {{-- Downloads Count --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Downloads Count</label>
          <input type="number" name="downloads_count" class="form-control" value="{{ old('downloads_count', $issue->downloads_count) }}" readonly>
          <small class="text-muted">Automatically updated - Current: {{ $issue->downloads_count }}</small>
        </div>
      </div>

      {{-- Published Paper PDF --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Published Paper PDF</label>
        <input type="file" name="published_paper_pdf" class="form-control" accept=".pdf">
        @if($issue->published_paper_pdf)
          <div class="mt-2">
            <small class="text-muted">Current file: {{ basename($issue->published_paper_pdf) }}</small><br>
            <a href="{{ route('issues.viewPdf', $issue) }}" target="_blank" class="btn btn-sm btn-primary mt-1">
                View PDF
            </a>
            <a href="{{ route('issues.download', $issue) }}" class="btn btn-sm btn-success mt-1">
                Download PDF
            </a>
          </div>
        @endif
      </div>

      {{-- Archive Cover Image --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Archive Cover Image</label>
        <input type="file" name="cover_image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
        <small class="text-muted">Upload a cover for this Volume/Issue. Maximum 5MB.</small>
        @if($issue->cover_image)
          <div class="mt-2 d-flex align-items-start gap-3">
            <img src="{{ asset('storage/app/public/' . ltrim($issue->cover_image, '/')) }}"
                 alt="Current issue cover"
                 style="width:110px; height:145px; object-fit:contain; border:1px solid #dce5df; border-radius:4px; padding:4px; background:#fbfdfb;">
            <div>
              <small class="text-muted d-block">Current cover is saved.</small>
              <small class="text-muted d-block">Uploading a new cover will keep the previous file.</small>
            </div>
          </div>
        @else
          <small class="text-muted d-block mt-2">No archive cover uploaded yet.</small>
        @endif
      </div>

      {{-- Paper Certificate
      <div class="mb-3">
        <label class="form-label fw-semibold">Paper Certificate</label>
        <input type="file" name="paper_certificate" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
        @if($issue->paper_certificate)
          <div class="mt-2">
            <small class="text-muted">Current file: {{ basename($issue->paper_certificate) }}</small><br>
            <a href="{{ asset('storage/certificates/' . $issue->paper_certificate) }}" target="_blank" class="btn btn-sm btn-info mt-1">
                View Certificate
            </a>
          </div>
        @endif
        <small class="text-muted">Accepted formats: JPG, PNG, PDF</small>
      </div> --}}

      {{-- Buttons --}}
      <div class="d-flex gap-2 justify-content-center">
        <button class="btn" style="background-color:#27b71f; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">
          Update Issue
        </button>
        <a href="{{ route('admin.issues.index') }}" class="btn" style="background-color:#cc7a00; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">
          Cancel
        </a>
      </div>
    </form>
  </div>
</div>
@endsection
