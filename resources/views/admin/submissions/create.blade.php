@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-center">
  <div style="width:100%; max-width:750px;">

    <h4 class="mb-4 text-center" style="color:#00004d; font-weight:600;">Add Submission</h4>

    @if ($errors->any())
      <div class="alert alert-danger mb-4">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.submissions.store') }}" 
          style="background:#ffffff; padding:25px; border-radius:10px; box-shadow:0px 4px 12px rgba(0,0,0,0.15);" novalidate>
      @csrf

      {{-- Title --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" required value="{{ old('title') }}">
        @error('title')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Previous Paper ID</label>
        <input type="text" name="previous_paper_id" class="form-control" value="{{ old('previous_paper_id') }}">
      </div>

      {{-- Research Area --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Research Area <span class="text-danger">*</span></label>
        <input type="text" name="research_area" class="form-control @error('research_area') is-invalid @enderror" required value="{{ old('research_area') }}">
        @error('research_area')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      {{-- Author Main Name --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Author Main Name <span class="text-danger">*</span></label>
        <input type="text" name="author_main_name" class="form-control @error('author_main_name') is-invalid @enderror" required value="{{ old('author_main_name') }}">
        @error('author_main_name')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      {{-- Author Designation --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Author Designation</label>
        <input type="text" name="author_main_designation" class="form-control @error('author_main_designation') is-invalid @enderror" value="{{ old('author_main_designation') }}">
        @error('author_main_designation')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      {{-- Author Institution --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Author Institution</label>
        <input type="text" name="author_main_institute" class="form-control @error('author_main_institute') is-invalid @enderror" value="{{ old('author_main_institute') }}">
        @error('author_main_institute')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      {{-- Author Main Email --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Author Main Email <span class="text-danger">*</span></label>
        <input type="email" name="author_main_email" id="author_main_email"
               class="form-control @error('author_main_email') is-invalid @enderror"
               required value="{{ old('author_main_email') }}">
        <div class="text-danger mt-1 small" id="email-error" style="display:none;"></div>
        @error('author_main_email')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      {{-- Author Mobile --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Author Mobile</label>
        <input type="text" 
               name="author_main_mobile" 
               class="form-control @error('author_main_mobile') is-invalid @enderror" 
               maxlength="10" 
               pattern="\d{10}" 
               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);" 
               value="{{ old('author_main_mobile') }}">
        @error('author_main_mobile')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      {{-- Address Fields --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Address Line 1</label>
        <input type="text" name="address_line1" class="form-control @error('address_line1') is-invalid @enderror" value="{{ old('address_line1') }}">
        @error('address_line1')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Address Line 2</label>
        <input type="text" name="address_line2" class="form-control @error('address_line2') is-invalid @enderror" value="{{ old('address_line2') }}">
        @error('address_line2')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">City</label>
        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}">
        @error('city')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">State</label>
        <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" value="{{ old('state') }}">
        @error('state')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Country</label>
        <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country') }}">
        @error('country')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Pincode</label>
        <input type="text" name="pincode" class="form-control @error('pincode') is-invalid @enderror" value="{{ old('pincode') }}" pattern="[0-9]{6}" title="Pincode must be exactly 6 digits">
        @error('pincode')
          <div class="text-danger mt-1 small">Pincode must be exactly 6 digits</div>
        @enderror
      </div>

      {{-- Co-Authors --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Co-Authors (Optional)</label>
        @php
          $coAuthors = is_array(old('co_authors')) ? old('co_authors') : [];
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
        @error('co_authors')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      {{-- File Upload --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Upload File (DOC/DOCX) <span class="text-danger">*</span></label>
        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".doc,.docx" required>
        @error('file')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">Plagiarism Report (PDF)</label>
        <input type="file" name="plagiarism_report" class="form-control" accept="application/pdf,.pdf">
      </div>

      <div class="mb-3">
        <label class="form-label fw-semibold">AI Content Detection Report (PDF, optional)</label>
        <input type="file" name="ai_report" class="form-control" accept="application/pdf,.pdf">
      </div>

      {{-- Status --}}
      <div class="mb-3">
        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
          <option value="">Select Status</option>
          @foreach($statuses as $value => $label)
            <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
        @error('status')
          <div class="text-danger mt-1 small">{{ $message }}</div>
        @enderror
      </div>

      {{-- Buttons --}}
      <div class="d-flex gap-2 justify-content-center">
        <button type="submit" class="btn" style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Save</button>
        <a href="{{ route('admin.submissions.index') }}" class="btn" style="background-color:#cc7a00; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Cancel</a>
      </div>
    </form>

  </div>
</div>

<script>
  document.querySelector("form").addEventListener("submit", function (e) {
    const emailInput = document.getElementById("author_main_email");
    const errorDiv = document.getElementById("email-error");
    errorDiv.style.display = "none";
    errorDiv.innerText = "";

    if (!emailInput.value.trim()) {
      e.preventDefault();
      errorDiv.innerText = "Please fill out this field";
      errorDiv.style.display = "block";
    } else if (!emailInput.value.includes("@")) {
      e.preventDefault();
      errorDiv.innerText = "Enter a valid email address with @ symbol";
      errorDiv.style.display = "block";
    }
  });
</script>
@endsection
