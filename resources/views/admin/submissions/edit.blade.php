@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-center">
  <div style="width:100%; max-width:750px;">

    <h4 class="mb-4 text-center" style="color:#00004d; font-weight:600;">Edit Submission</h4>

    @if ($errors->any())
      <div class="alert alert-danger mb-4">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.submissions.update', $submission->id) }}" 
          style="background:#ffffff; padding:25px; border-radius:10px; box-shadow:0px 4px 12px rgba(0,0,0,0.15);">
      @csrf
      @method('PUT')

      {{-- Title --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control" required value="{{ old('title', $submission->title) }}">
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Paper ID</label>
        <input type="text" class="form-control" value="{{ $submission->paper_id ?: 'Not assigned' }}" readonly>
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Previous Paper ID</label>
        <input type="text" name="previous_paper_id" class="form-control" value="{{ old('previous_paper_id', $submission->previous_paper_id) }}">
      </div>

      {{-- Research Area --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Research Area <span class="text-danger">*</span></label>
        <input type="text" name="research_area" class="form-control" required value="{{ old('research_area', $submission->research_area) }}">
      </div>

      {{-- Author Main Name --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Author Name <span class="text-danger">*</span></label>
        <input type="text" name="author_main_name" class="form-control" required value="{{ old('author_main_name', $submission->author_main_name) }}">
      </div>

      {{-- Author Designation --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Author Designation</label>
        <input type="text" name="author_main_designation" class="form-control" value="{{ old('author_main_designation', $submission->author_main_designation) }}">
      </div>

      {{-- Author Institution --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Author Institution</label>
        <input type="text" name="author_main_institute" class="form-control" value="{{ old('author_main_institute', $submission->author_main_institute) }}">
      </div>

      {{-- Author Email --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Author Email <span class="text-danger">*</span></label>
        <input type="email" name="author_main_email" class="form-control" required value="{{ old('author_main_email', $submission->author_main_email) }}">
      </div>

      {{-- Author Mobile --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Author Phone</label>
        <input type="text" 
               name="author_main_mobile" 
               class="form-control" 
               maxlength="10" 
               pattern="\d{10}" 
               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);" 
               value="{{ old('author_main_mobile', $submission->author_main_mobile) }}"
               required>
      </div>

      {{-- Address --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Address Line 1</label>
        <input type="text" name="address_line1" class="form-control" value="{{ old('address_line1', $submission->address_line1) }}">
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Address Line 2</label>
        <input type="text" name="address_line2" class="form-control" value="{{ old('address_line2', $submission->address_line2) }}">
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">City</label>
        <input type="text" name="city" class="form-control" value="{{ old('city', $submission->city) }}">
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">State</label>
        <input type="text" name="state" class="form-control" value="{{ old('state', $submission->state) }}">
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Country</label>
        <input type="text" name="country" class="form-control" value="{{ old('country', $submission->country) }}">
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Pincode</label>
        <input type="text" name="pincode" class="form-control" value="{{ old('pincode', $submission->pincode) }}" pattern="[0-9]{6}">
      </div>

      {{-- Co-Authors --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Co-Authors (Optional)</label>
        @php
          $coAuthors = is_array(old('co_authors')) ? old('co_authors') : ($submission->co_authors ?? []);
        @endphp
        @for($i = 0; $i < 3; $i++)
          @php
            $coAuthor = $coAuthors[$i] ?? [];
          @endphp
          <div class="border rounded p-3 mb-3 bg-light">
            <div class="fw-semibold mb-2">Co-Author {{ $i + 1 }}</div>
            <div class="row g-2">
              <div class="col-md-6">
                <input type="text" name="co_authors[{{ $i }}][name]" class="form-control" placeholder="Full Name" value="{{ $coAuthor['name'] ?? '' }}">
              </div>
              <div class="col-md-6">
                <input type="text" name="co_authors[{{ $i }}][designation]" class="form-control" placeholder="Designation" value="{{ $coAuthor['designation'] ?? '' }}">
              </div>
              <div class="col-md-6">
                <input type="text" name="co_authors[{{ $i }}][institute]" class="form-control" placeholder="Institute / Organization" value="{{ $coAuthor['institute'] ?? '' }}">
              </div>
              <div class="col-md-6">
                <input type="email" name="co_authors[{{ $i }}][email]" class="form-control" placeholder="Email Address" value="{{ $coAuthor['email'] ?? '' }}">
              </div>
            </div>
          </div>
        @endfor
        <small class="text-muted">Enter details for up to 3 co-authors. Leave unused sections blank.</small>
      </div>

      {{-- File Upload --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Upload File (DOC/DOCX)</label>
        <input type="file" name="file" class="form-control" accept=".doc,.docx">
        {{-- Use $submission instead of $document --}}
        @if($submission->file_path)
            @php
                // Extract just the filename from the path
                $filename = basename($submission->file_path);
            @endphp
            
            <a href="{{ route('admin.submissions.file', ['submission' => $submission, 'type' => 'manuscript']) }}"
              target="_blank" 
              class="btn btn-info">
                📄 View Document
            </a>
        @else
            <span class="text-warning">No document available</span>
        @endif
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Plagiarism Report (PDF)</label>
        <input type="file" name="plagiarism_report" class="form-control" accept="application/pdf,.pdf">
        @if($submission->plagiarism_report_path)
          <a class="btn btn-outline-danger btn-sm mt-2" target="_blank" href="{{ route('admin.submissions.file', ['submission' => $submission, 'type' => 'plagiarism-report']) }}">View Plagiarism Report</a>
        @endif
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">AI Content Detection Report (PDF, optional)</label>
        <input type="file" name="ai_report" class="form-control" accept="application/pdf,.pdf">
        @if($submission->ai_report_path)
          <a class="btn btn-outline-secondary btn-sm mt-2" target="_blank" href="{{ route('admin.submissions.file', ['submission' => $submission, 'type' => 'ai-report']) }}">View AI Report</a>
        @endif
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Acknowledgement Email</label>
        @if($submission->email_sent_at)
          <div class="text-success small">Sent on {{ $submission->email_sent_at->format('d M Y, h:i A') }}</div>
        @else
          <div class="text-danger small mb-2">Not sent{{ $submission->email_error ? ': '.$submission->email_error : '' }}</div>
          <button type="submit" formmethod="POST" formaction="{{ route('admin.submissions.retry-acknowledgement', $submission) }}" class="btn btn-outline-primary btn-sm">Retry Acknowledgement Email</button>
        @endif
      </div>

      {{-- Status --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select" required>
          @foreach($statuses as $value => $label)
            <option value="{{ $value }}" {{ $submission->status == $value ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>

      {{-- Buttons --}}
      <div class="d-flex gap-2 justify-content-center">
        <button class="btn" style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Update</button>
        <a href="{{ route('admin.submissions.index') }}" class="btn" style="background-color:#cc7a00; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Cancel</a>
      </div>
    </form>

  </div>
</div>
@endsection
