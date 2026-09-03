@extends('admin.layouts.app')

@section('title', 'Add Issue')
@section('content')

<div class="d-flex justify-content-center">
  <div style="width:100%; max-width:800px;">
    <h4 class="mb-4 text-center" style="color:#00004d; font-weight:600;">Add Issue</h4>

    <form method="POST" action="{{ route('admin.issues.store') }}" enctype="multipart/form-data"
          style="background:#ffffff; padding:25px; border-radius:10px; box-shadow:0px 4px 12px rgba(0,0,0,0.15);">
      @csrf

      <div class="row">
        {{-- Title --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
          <input type="text" name="title" class="form-control" required>
        </div>

        {{-- Volume --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Volume <span class="text-danger">*</span></label>
          <input type="text" name="volume" class="form-control" required>
        </div>
      </div>

      {{-- Abstract --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Abstract</label>
        <textarea name="abstract" class="form-control" rows="4" placeholder="Enter paper abstract"></textarea>
      </div>

      <div class="row">
        {{-- Number --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Number <span class="text-danger">*</span></label>
          <input type="text" name="number" class="form-control" required>
        </div>

        {{-- Publish Date --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Publish Date</label>
          <input type="date" name="publish_date" class="form-control">
        </div>
      </div>

      <div class="row">
        {{-- Registration ID --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Registration ID</label>
          <input type="text" name="registration_id" class="form-control">
        </div>

        {{-- Published Paper ID --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Published Paper ID</label>
          <input type="text" name="published_paper_id" class="form-control">
        </div>
      </div>

      <div class="row">
        {{-- Year --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Year <span class="text-danger">*</span></label>
          <input type="text" name="year" class="form-control" required>
        </div>

        {{-- Approved eISSN --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Approved eISSN</label>
          <input type="text" name="approved_eissn" class="form-control">
        </div>
      </div>

      <div class="row">
        {{-- Country --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Country</label>
          <input type="text" name="country" class="form-control">
        </div>

        {{-- CrossRef DOI Member ID --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold"> DOI</label>
          <input type="text" name="crossref_doi_member_id" class="form-control">
        </div>
      </div>

      <div class="row">
        {{-- Page No --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Page No</label>
          <input type="text" name="page_no" class="form-control">
        </div>

        {{-- Downloads Count --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Downloads Count</label>
          <input type="number" name="downloads_count" class="form-control" value="0" readonly>
          <small class="text-muted">This will be automatically updated when users download the PDF</small>
        </div>
      </div>

      <div class="row">
        {{-- Published Paper PDF --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Published Paper PDF</label>
          <input type="file" name="published_paper_pdf" class="form-control" accept=".pdf">
        </div>

        {{-- Archive Cover Image --}}
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Archive Cover Image</label>
          <input type="file" name="cover_image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
          <small class="text-muted">This cover will appear for this Volume/Issue in the archive. Maximum 5MB.</small>
        </div>

        {{-- Paper Certificate
        <div class="col-md-6 mb-3">
          <label class="form-label fw-semibold">Paper Certificate</label>
          <input type="file" name="paper_certificate" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
          <small class="text-muted">Accepted formats: JPG, PNG, PDF</small>
        </div>
      </div> --}}

      {{-- Buttons --}}
      <div class="d-flex gap-2 justify-content-center">
        <button class="btn" style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Save Issue</button>
        <a href="{{ route('admin.issues.index') }}" class="btn" style="background-color:#cc7a00; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
