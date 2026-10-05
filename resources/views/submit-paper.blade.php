@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    :root {
        --primary-dark: #00004d;
        --primary-accent: #cc7a00;
        --success-color: #00cc00;
        --success-dark: #003300;
        --text-dark: #000000;
        --text-light: #ffffff;
        --light-bg: #f8f9fa;
    }

    .page-header {
        font-size: 32px;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 3px solid var(--primary-accent);
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    .instruction-box {
        background: linear-gradient(to right, #f9f9f9 95%, var(--primary-dark) 5%);
        border-left: 4px solid var(--primary-accent);
        border-radius: 5px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .card {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border: none;
        margin-bottom: 25px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-top: 3px solid var(--primary-dark);
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        background-color: var(--primary-dark);
        color: var(--text-light);
        font-weight: 600;
        font-size: 18px;
    }

    .btn-primary {
        background-color: var(--primary-dark);
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: var(--primary-accent);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-success {
        background-color: var(--success-dark);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background-color: var(--success-color);
        transform: translateY(-2px);
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 5px;
        color: var(--primary-dark);
    }

    .required-field::after {
        content: "*";
        color: #e74c3c;
        margin-left: 3px;
    }

    .form-control,
    .form-select {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-accent);
        box-shadow: 0 0 0 0.25rem rgba(204, 122, 0, 0.25);
    }

    .co-author-row {
        background-color: rgba(0, 0, 77, 0.03);
        border-left: 3px solid var(--success-color) !important;
    }

    .alert-success {
        background-color: rgba(0, 204, 0, 0.15);
        border-color: var(--success-color);
        color: var(--success-dark);
    }

    .alert-danger {
        background-color: rgba(231, 76, 60, 0.15);
        border-color: #e74c3c;
        color: #c0392b;
    }

    #message-container {
        position: relative;
        max-width: 100%;
        width: 100%;
        margin: 0 auto 1.5rem;
    }

    #message-container .alert {
        position: relative;
        margin-bottom: 1rem;
    }

    .submission-success-card {
        max-width: 780px;
        margin-left: auto;
        margin-right: auto;
    }

    .submission-success-card .card-body {
        padding: 3rem 2rem;
    }

    .submission-success-card h2 {
        font-size: clamp(1.5rem, 3vw, 2.25rem);
        margin-bottom: 1rem;
    }

    .submission-success-card .paper-id {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        margin: 0.5rem 0 1rem;
        border: 1px solid rgba(0, 51, 0, 0.2);
        border-radius: 0.5rem;
        background: #f0fff4;
        color: var(--success-dark);
        font-size: 1.25rem;
    }

    .remove-author-btn {
        transition: all 0.3s ease;
    }

    .remove-author-btn:hover {
        transform: scale(1.05);
    }

    .form-check-input:checked {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .form-check-input:focus {
        border-color: var(--primary-accent);
        box-shadow: 0 0 0 0.25rem rgba(204, 122, 0, 0.25);
    }

    .invalid-phone {
        border-color: #e74c3c !important;
        box-shadow: 0 0 0 0.25rem rgba(231, 76, 60, 0.25) !important;
    }

    .phone-error {
        color: #e74c3c;
        font-size: 0.875em;
        margin-top: 5px;
        display: none;
    }

    .verification-box {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        border-left: 4px solid var(--primary-accent);
    }

    .verification-question {
        font-weight: bold;
        font-size: 18px;
        margin-right: 10px;
    }

    .error-message {
        color: #e74c3c;
        font-size: 0.875em;
        margin-top: 5px;
        display: none;
    }

    .is-invalid {
        border-color: #e74c3c !important;
        box-shadow: 0 0 0 0.25rem rgba(231, 76, 60, 0.25) !important;
    }

    /* === WIZARD STYLES === */
    .step-progress-wrapper {
        margin-bottom: 35px;
    }

    .step-progress {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        margin-bottom: 20px;
        padding: 0 20px;
    }

    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        cursor: default;
        position: relative;
        z-index: 1;
    }

    .step-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        border: 2.5px solid #d1d5db;
        background: #fff;
        color: #9ca3af;
        transition: all 0.35s ease;
        position: relative;
    }

    .step-item.active .step-circle {
        border-color: var(--primary-dark);
        background: var(--primary-dark);
        color: #fff;
        box-shadow: 0 0 0 5px rgba(0, 0, 77, 0.12);
        transform: scale(1.08);
    }

    .step-item.completed .step-circle {
        border-color: #059669;
        background: #059669;
        color: #fff;
    }

    .step-label {
        font-size: 12px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: color 0.35s ease;
        white-space: nowrap;
    }

    .step-item.active .step-label {
        color: var(--primary-dark);
    }

    .step-item.completed .step-label {
        color: #059669;
    }

    .step-connector {
        flex: 1;
        min-width: 40px;
        max-width: 120px;
        height: 2.5px;
        background: #e5e7eb;
        margin: 0 8px;
        align-self: center;
        margin-bottom: 28px;
        transition: background 0.35s ease;
        position: relative;
        z-index: 0;
    }

    .step-connector.completed {
        background: #059669;
    }

    .step-header {
        text-align: center;
        font-size: 18px;
        font-weight: 600;
        color: var(--primary-dark);
        background: #fff;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border: 1px solid #e5e7eb;
    }

    .step-container {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        padding: 30px;
        border: 1px solid #e5e7eb;
    }

    .step-content {
        display: none;
        opacity: 0;
    }

    .step-content.step-active {
        display: block;
        animation: stepFadeIn 0.4s ease forwards;
    }

    @keyframes stepFadeIn {
        0% {
            opacity: 0;
            transform: translateX(24px);
        }

        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .step-navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #e5e7eb;
    }

    .step-navigation .btn {
        min-width: 140px;
    }

    .step-navigation .btn-outline-secondary {
        border-color: #d1d5db;
        color: #6b7280;
    }

    .step-navigation .btn-outline-secondary:hover {
        border-color: var(--primary-dark);
        background: var(--primary-dark);
        color: #fff;
    }

    @media (max-width: 576px) {
        .step-container {
            padding: 16px;
            border-radius: 12px;
        }

        .step-circle {
            width: 36px;
            height: 36px;
            font-size: 14px;
        }

        .step-label {
            font-size: 10px;
        }

        .step-connector {
            min-width: 20px;
        }

        .step-navigation {
            flex-direction: column;
            gap: 12px;
        }

        .step-navigation .btn {
            width: 100%;
            min-width: unset;
        }

        .step-navigation>div {
            width: 100%;
            display: flex;
            gap: 10px;
        }

        .step-navigation>div:first-child {
            order: 2;
        }

        .step-navigation>div:last-child {
            order: 1;
        }

        .step-navigation>div .btn {
            flex: 1;
        }

        .page-header {
            font-size: 24px;
        }
    }

    @media (min-width: 577px) and (max-width: 768px) {
        .step-container {
            padding: 20px;
        }

        .step-connector {
            min-width: 30px;
        }
    }
</style>

<div class="container my-5">
    <h1 class="text-center page-header">Submit Research Paper</h1>

    <!-- Success / Error Messages -->
    <div id="message-container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center">
            <h4 class="alert-heading">Success!</h4>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        @foreach($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show">
            {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endforeach
        @endif
    </div>

    <!-- Instructions -->
    <div class="mb-4 p-4 instruction-box">
        <h2 class="mb-3" style="font-size: 20px; font-weight: bold; color: var(--primary-dark);">Important Instructions</h2>
        <ul style="line-height: 1.8;">
            <li>Fill all details carefully. Certificate and journal listing will be generated exactly as per information provided.</li>
            <li>Fields marked with <span class="text-danger">*</span> are mandatory.</li>
            <li>Corresponding author (first author) will receive all communications regarding acceptance, payment, and publication.</li>
            <li>Do not enter names or titles in all capital letters. Use capital letters only at the beginning of each word.</li>
            <li>The submitted paper must be in <strong>.doc</strong> or <strong>.docx</strong> format only.</li>
            <li>Plagiarism/similarity and AI content detection reports may be uploaded as PDF files when available.</li>
            <li>Mobile number must be exactly 10 digits.</li>
            <li>The copyright form is requested by email only after acceptance; it is not uploaded here.</li>
        </ul>
    </div>

    @if(session('paper_id'))
    <div class="card border-success mb-4 submission-success-card">
        <div class="card-body text-center py-5">
            <div class="display-5 text-success mb-3"><i class="bi bi-check-circle-fill"></i></div>
            <h2 class="text-success">Manuscript Submitted Successfully!</h2>
            <p class="lead mb-3">Thank you for submitting your manuscript to BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD).</p>
            <p class="paper-id"><strong>Paper ID: {{ session('paper_id') }}</strong></p>
            @if(session('email_sent'))
                <p class="text-success mb-2">An acknowledgement email has been sent to your registered email address.</p>
            @else
                <p class="text-warning mb-2">Your manuscript was saved, but the acknowledgement email could not be sent. The editorial team can retry it.</p>
            @endif
            <p class="text-muted mb-0">Please save your Paper ID for all future correspondence. This acknowledgement confirms receipt only and does not constitute acceptance for publication.</p>
        </div>
    </div>
    @else

    <!-- Step Progress Indicator -->
    <div class="step-progress-wrapper">
        <div class="step-progress">
            <div class="step-item active" data-step="1">
                <div class="step-circle"><i class="bi bi-file-text d-none"></i><span class="step-num">1</span></div>
                <div class="step-label">Paper Info</div>
            </div>
            <div class="step-connector" data-connector="1"></div>
            <div class="step-item" data-step="2">
                <div class="step-circle"><i class="bi bi-people d-none"></i><span class="step-num">2</span></div>
                <div class="step-label">Authors</div>
            </div>
            <div class="step-connector" data-connector="2"></div>
            <div class="step-item" data-step="3">
                <div class="step-circle"><i class="bi bi-check-lg d-none"></i><span class="step-num">3</span></div>
                <div class="step-label">Review</div>
            </div>
        </div>
        <div class="step-header">
            <i class="bi bi-1-circle me-2"></i> Step 1 of 3: Paper Information
        </div>
    </div>

    <!-- Form -->
    <div class="step-container">
        <form id="paper-submission-form" action="{{ route('submit.paper.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="submission_token" value="{{ old('submission_token', (string) \Illuminate\Support\Str::uuid()) }}">

            <!-- ===== STEP 1: Paper Information ===== -->
            <div class="step-content step-active" id="step-1">
                <!-- Previous Paper ID -->
                <div class="card mb-4">
                    <div class="card-header"><i class="bi bi-folder-open me-2"></i> Previous Paper ID (If Applicable)</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">If you've published in BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE before, enter your previous Paper ID</label>
                            <input type="text" name="previous_paper_id" class="form-control" placeholder="Enter previous Paper ID" value="{{ old('previous_paper_id') }}">
                        </div>
                    </div>
                </div>

                <!-- Paper Details -->
                <div class="card mb-4">
                    <div class="card-header"><i class="bi bi-journal-text me-2"></i> Paper Details</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required-field">Paper Title</label>
                            <input type="text" name="title" class="form-control" required placeholder="Enter full title of your research paper" value="{{ old('title') }}">
                            <div class="error-message" id="title-error">Title can only contain letters, numbers, spaces, and basic punctuation</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required-field">Upload Paper</label>
                            <input type="file" name="paper_file" class="form-control" required accept=".doc,.docx">
                            <small class="text-muted">.doc or .docx file only (Max: 10MB)</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Plagiarism Report</label>
                            <input type="file" name="plagiarism_report" class="form-control" accept="application/pdf,.pdf">
                            <small class="text-muted">PDF file only (Max: 10MB). You may upload this report if available.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload AI Content Detection Report</label>
                            <input type="file" name="ai_report" class="form-control" accept="application/pdf,.pdf">
                            <small class="text-muted">PDF file only (Max: 10MB). You may upload this report if available.</small>
                        </div>
                         <div class="mb-3">
                            <label class="form-label required-field">Area of Research</label>
                            <select name="research_area" class="form-select" required>
                                <option value="">Select Area</option>

                                <option value="Arts, Humanities & Languages" {{ old('research_area') == 'Arts, Humanities & Languages' ? 'selected' : '' }}>
                                    Arts, Humanities & Languages
                                </option>

                                <option value="Commerce, Management & Economics" {{ old('research_area') == 'Commerce, Management & Economics' ? 'selected' : '' }}>
                                    Commerce, Management & Economics
                                </option>

                                <option value="Education & Psychology" {{ old('research_area') == 'Education & Psychology' ? 'selected' : '' }}>
                                    Education & Psychology
                                </option>

                                <option value="Library & Information Science" {{ old('research_area') == 'Library & Information Science' ? 'selected' : '' }}>
                                    Library & Information Science
                                </option>

                                <option value="Computer Science, IT & Artificial Intelligence" {{ old('research_area') == 'Computer Science, IT & Artificial Intelligence' ? 'selected' : '' }}>
                                    Computer Science, IT & Artificial Intelligence
                                </option>

                                <option value="Engineering & Technology" {{ old('research_area') == 'Engineering & Technology' ? 'selected' : '' }}>
                                    Engineering & Technology
                                </option>

                                <option value="Mathematics & Physical Sciences" {{ old('research_area') == 'Mathematics & Physical Sciences' ? 'selected' : '' }}>
                                    Mathematics & Physical Sciences
                                </option>

                                <option value="Life Sciences & Biotechnology" {{ old('research_area') == 'Life Sciences & Biotechnology' ? 'selected' : '' }}>
                                    Life Sciences & Biotechnology
                                </option>

                                <option value="Environmental & Agricultural Sciences" {{ old('research_area') == 'Environmental & Agricultural Sciences' ? 'selected' : '' }}>
                                    Environmental & Agricultural Sciences
                                </option>

                                <option value="Health Sciences & Public Health" {{ old('research_area') == 'Health Sciences & Public Health' ? 'selected' : '' }}>
                                    Health Sciences & Public Health
                                </option>

                                <option value="Social Sciences & Public Administration" {{ old('research_area') == 'Social Sciences & Public Administration' ? 'selected' : '' }}>
                                    Social Sciences & Public Administration
                                </option>

                                <option value="Law & Legal Studies" {{ old('research_area') == 'Law & Legal Studies' ? 'selected' : '' }}>
                                    Law & Legal Studies
                                </option>

                                <option value="Media, Communication & Journalism" {{ old('research_area') == 'Media, Communication & Journalism' ? 'selected' : '' }}>
                                    Media, Communication & Journalism
                                </option>

                                <option value="Tourism, Hospitality & Event Management" {{ old('research_area') == 'Tourism, Hospitality & Event Management' ? 'selected' : '' }}>
                                    Tourism, Hospitality & Event Management
                                </option>

                                <option value="Physical Education & Sports Sciences" {{ old('research_area') == 'Physical Education & Sports Sciences' ? 'selected' : '' }}>
                                    Physical Education & Sports Sciences
                                </option>

                                <option value="Gender, Rural & Development Studies" {{ old('research_area') == 'Gender, Rural & Development Studies' ? 'selected' : '' }}>
                                    Gender, Rural & Development Studies
                                </option>

                                <option value="Interdisciplinary & Emerging Research" {{ old('research_area') == 'Interdisciplinary & Emerging Research' ? 'selected' : '' }}>
                                    Interdisciplinary & Emerging Research
                                </option>

                                <option value="Other" {{ old('research_area') == 'Other' ? 'selected' : '' }}>
                                    Other
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== STEP 2: Author Details ===== -->
            <div class="step-content" id="step-2">
                <!-- Main Author -->
                <div class="card mb-4">
                    <div class="card-header"><i class="bi bi-person-badge me-2"></i> Main Author (Corresponding Author)</div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required-field">Full Name</label>
                                <input type="text" name="author_main_name" class="form-control" required placeholder="First + Last Name" value="{{ old('author_main_name') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required-field">Designation</label>
                                <input type="text" name="author_main_designation" class="form-control" required placeholder="e.g., Assistant Professor" value="{{ old('author_main_designation') }}">
                                <div class="error-message" id="author_main_designation-error">Designation can only contain letters, spaces, and basic punctuation</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required-field">Institute/Organization Name</label>
                                <input
                                    type="text"
                                    name="author_main_institute"
                                    class="form-control"
                                    required
                                    placeholder="Full official name"
                                    value="{{ old('author_main_institute') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required-field">Email ID</label>
                                <input type="email" name="author_main_email" class="form-control" required
                                    placeholder="Valid email for communication" value="{{ old('author_main_email') }}">
                                <div class="error-message" id="author_main_email-error">Please provide a valid email address</div>
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required-field">Mobile Number</label>
                                <input type="text" name="author_main_mobile" id="author_main_mobile" class="form-control" required placeholder="10-digit mobile number" pattern="[0-9]{10}" value="{{ old('author_main_mobile') }}">
                                <div class="phone-error" id="author_main_mobile_error">Please enter exactly 10 digits</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Co-Authors -->
                <div class="card mb-4">
                    <div class="card-header"><i class="bi bi-people me-2"></i> Co-Author(s) Details (If Applicable)</div>
                    <div class="card-body">
                        <div id="co-authors-wrapper">
                            @if(old('co_authors'))
                            @foreach(old('co_authors') as $index => $coAuthor)
                            <div class="border p-3 mb-3 rounded co-author-row">
                                <h5>Co-Author {{ $index + 1 }}</h5>
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="co_authors[{{ $index }}][name]" class="form-control co-author-name" value="{{ $coAuthor['name'] ?? '' }}" placeholder="Full Name">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Designation</label>
                                        <input type="text" name="co_authors[{{ $index }}][designation]" class="form-control" value="{{ $coAuthor['designation'] ?? '' }}" placeholder="Designation">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Institute / Organization Name</label>
                                        <input type="text" name="co_authors[{{ $index }}][institute]" class="form-control" value="{{ $coAuthor['institute'] ?? '' }}" placeholder="Institute / Organization Name">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="co_authors[{{ $index }}][email]" class="form-control co-author-email" value="{{ $coAuthor['email'] ?? '' }}" placeholder="Email address">
                                        <div class="error-message">Please provide a valid email address</div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-danger remove-author-btn">Remove</button>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-success btn-sm mt-2" id="add-author-btn"><i class="bi bi-plus-circle me-1"></i> Add Co-Author</button>
                    </div>
                </div>
            </div>

            <!-- ===== STEP 3: Review & Submit ===== -->
            <div class="step-content" id="step-3">
                <!-- Address -->
                <div class="card mb-4">
                    <div class="card-header"><i class="bi bi-geo-alt me-2"></i> Address for Communication</div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required-field">Address Line 1</label>
                                <input type="text" name="address_line1" class="form-control" required value="{{ old('address_line1') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address Line 2</label>
                                <input type="text" name="address_line2" class="form-control" value="{{ old('address_line2') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label required-field">City</label>
                                <input type="text" name="city" class="form-control" required value="{{ old('city') }}">
                                <div class="error-message" id="city-error">City can only contain letters and spaces</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required-field">State</label>
                                <input type="text" name="state" class="form-control" required value="{{ old('state') }}">
                                <div class="error-message" id="state-error">State can only contain letters and spaces</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required-field">Country</label>
                                <input type="text" name="country" class="form-control" required value="{{ old('country') }}">
                                <div class="error-message" id="country-error">Country can only contain letters and spaces</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required-field">Pincode</label>
                                <input type="text"
                                    name="pincode"
                                    id="pincode"
                                    class="form-control"
                                    required
                                    value="{{ old('pincode') }}"
                                    maxlength="6"
                                    pattern="[0-9]{6}"
                                    title="Pincode must be exactly 6 digits">
                                <div class="error-message" id="pincode-error" style="display:none; color:red;">
                                    Pincode must be exactly 6 digits
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Verification -->
                <div class="card mb-4">
                    <div class="card-header"><i class="bi bi-shield-lock me-2"></i> Verification</div>
                    <div class="card-body">
                        <div class="verification-box">
                            <div class="d-flex align-items-center mb-2">
                                <span class="verification-question" id="verification-question">{{ $verificationQuestion }}</span>
                                <input type="text" id="verification_answer" name="verification_answer" class="form-control" style="width: 80px;" required>
                            </div>
                            <small class="text-muted">Please solve this simple math problem to verify you're human</small>
                            <div class="error-message" id="verification-error">Incorrect answer. Please try again.</div>
                        </div>
                    </div>
                </div>

                <!-- Author Declaration & Consent -->
                <div class="card mb-4">
                    <div class="card-header"><i class="bi bi-file-earmark-check me-2"></i> Author Declaration & Consent</div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input declaration-checkbox" type="checkbox" id="originality_declaration" name="originality_declaration" required {{ old('originality_declaration') ? 'checked' : '' }}>
                            <label class="form-check-label" for="originality_declaration">I/We declare that the submitted manuscript is original work and has not been previously published or simultaneously submitted to another journal. <span class="text-danger">*</span></label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input declaration-checkbox" type="checkbox" id="authorship_consent" name="authorship_consent" required {{ old('authorship_consent') ? 'checked' : '' }}>
                            <label class="form-check-label" for="authorship_consent">I/We confirm that all listed authors have approved the manuscript and its submission to BJDD. <span class="text-danger">*</span></label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input declaration-checkbox" type="checkbox" id="ethics_declaration" name="ethics_declaration" required {{ old('ethics_declaration') ? 'checked' : '' }}>
                            <label class="form-check-label" for="ethics_declaration">I/We confirm that the manuscript complies with applicable research and publication ethics and that all sources have been appropriately acknowledged. <span class="text-danger">*</span></label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input declaration-checkbox" type="checkbox" id="journal_policies" name="journal_policies" required {{ old('journal_policies') ? 'checked' : '' }}>
                            <label class="form-check-label" for="journal_policies">I/We confirm that we have read and agree to comply with BJDD editorial, peer-review, plagiarism, ethics, and publication policies. <span class="text-danger">*</span></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input declaration-checkbox" type="checkbox" id="final_confirmation" name="final_confirmation" required {{ old('final_confirmation') ? 'checked' : '' }}>
                            <label class="form-check-label" for="final_confirmation">I/We confirm that all information and documents provided in this submission are true and complete. <span class="text-danger">*</span></label>
                        </div>
                        <div class="error-message" id="declaration-error">All declarations are required before submitting.</div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="step-navigation">
                <div>
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4" id="prevBtn">
                        <i class="bi bi-arrow-left"></i><span class="d-none d-sm-inline ms-2">Previous</span><span class="d-inline d-sm-none ms-2">Prev</span>
                    </button>
                </div>
                <div>
                    <button type="button" class="btn btn-primary btn-lg px-4" id="nextBtn">
                        <span class="d-none d-sm-inline me-2">Next</span><span class="d-inline d-sm-none me-2">Next</span><i class="bi bi-arrow-right"></i>
                    </button>
                    <button type="submit" class="btn btn-success btn-lg px-4" id="submitBtn" style="display:none;" disabled>
                        <i class="bi bi-check-circle me-2"></i> Submit Paper
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif
</div>

<script>
if (document.getElementById('paper-submission-form')) {
    let coAuthorCount = {{ old('co_authors') ? count(old('co_authors')) : 0 }};
    const maxCoAuthors = 3;


    function validatePhoneNumber(input) {
        const value = input.value.replace(/\D/g, '');
        const isValid = /^\d{10}$/.test(value);

        if (value && !isValid) {
            input.classList.add('invalid-phone');
            input.nextElementSibling.style.display = 'block';
            return false;
        } else {
            input.classList.remove('invalid-phone');
            input.nextElementSibling.style.display = 'none';
            return true;
        }
    }

    function formatPhoneInput(input) {

        let value = input.value.replace(/\D/g, '');


        if (value.length > 10) {
            value = value.slice(0, 10);
        }


        input.value = value;


        validatePhoneNumber(input);
    }

    function validateTextOnly(input, errorId) {
        const value = input.value.trim();
        const isValid = /^[a-zA-Z\s\-\.\'\(\)]*$/.test(value);

        if (value && !isValid) {
            input.classList.add('is-invalid');
            document.getElementById(errorId).style.display = 'block';
            return false;
        } else {
            input.classList.remove('is-invalid');
            document.getElementById(errorId).style.display = 'none';
            return true;
        }
    }

    function validateEmail(input, errorId) {
        const value = input.value.trim();
        const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);

        if (value && !isValid) {
            input.classList.add('is-invalid');
            if (errorId) {
                document.getElementById(errorId).style.display = 'block';
            }
            return false;
        } else {
            input.classList.remove('is-invalid');
            if (errorId) {
                document.getElementById(errorId).style.display = 'none';
            }
            return true;
        }
    }

    function validatePincode(input, errorId) {
        const value = input.value.trim();
        const isValid = /^\d+$/.test(value);

        if (value && !isValid) {
            input.classList.add('is-invalid');
            document.getElementById(errorId).style.display = 'block';
            return false;
        } else {
            input.classList.remove('is-invalid');
            document.getElementById(errorId).style.display = 'none';
            return true;
        }
    }

    function validateTitle(input, errorId) {
        const value = input.value.trim();
        const isValid = /^[a-zA-Z0-9\s\-\_\.\,\:\;\(\)\&\'\"]*$/.test(value);

        if (value && !isValid) {
            input.classList.add('is-invalid');
            document.getElementById(errorId).style.display = 'block';
            return false;
        } else {
            input.classList.remove('is-invalid');
            document.getElementById(errorId).style.display = 'none';
            return true;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 5000);
        }

        initStepWizard();
    });

    document.getElementById('add-author-btn').addEventListener('click', function() {
        if (coAuthorCount >= maxCoAuthors) {
            alert('Maximum 3 co-authors allowed.');
            return;
        }

        coAuthorCount++;
        const wrapper = document.getElementById('co-authors-wrapper');
        const html = `
            <div class="border p-3 mb-3 rounded co-author-row">
                <h5>Co-Author ${coAuthorCount}</h5>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <label class="form-label">Name</label>
                        <input type="text" name="co_authors[${coAuthorCount}][name]" class="form-control co-author-name" placeholder="Full Name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Designation</label>
                        <input type="text" name="co_authors[${coAuthorCount}][designation]" class="form-control" placeholder="Designation">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Institute / Organization Name</label>
                        <input type="text" name="co_authors[${coAuthorCount}][institute]" class="form-control" placeholder="Institute / Organization Name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="co_authors[${coAuthorCount}][email]" class="form-control co-author-email" placeholder="Email address">
                        <div class="error-message">Please provide a valid email address</div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-danger remove-author-btn">Remove</button>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);

        const emailInput = wrapper.lastElementChild.querySelector('.co-author-email');
        emailInput.addEventListener('blur', function() {
            validateEmail(this, null);
        });

        const removeBtn = wrapper.lastElementChild.querySelector('.remove-author-btn');
        removeBtn.addEventListener('click', function() {
            this.closest('.co-author-row').remove();
            coAuthorCount--;
        });
    });

    document.querySelectorAll('.remove-author-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.co-author-row').remove();
            coAuthorCount--;
        });
    });


    const mainDesignationInput = document.querySelector('input[name="author_main_designation"]');
    const mainEmailInput = document.querySelector('input[name="author_main_email"]');
    const mainMobileInput = document.getElementById('author_main_mobile');
    const titleInput = document.querySelector('input[name="title"]');
    const cityInput = document.querySelector('input[name="city"]');
    const stateInput = document.querySelector('input[name="state"]');
    const countryInput = document.querySelector('input[name="country"]');
    const pincodeInput = document.getElementById('pincode');

    if (mainDesignationInput) {
        mainDesignationInput.addEventListener('blur', function() {
            validateTextOnly(this, 'author_main_designation-error');
        });
    }

    if (mainEmailInput) {
        mainEmailInput.addEventListener('blur', function() {
            validateEmail(this, 'author_main_email-error');
        });
    }

    if (mainMobileInput) {
        mainMobileInput.addEventListener('input', function() {
            formatPhoneInput(this);
        });

        mainMobileInput.addEventListener('blur', function() {
            validatePhoneNumber(this);
        });
    }

    if (titleInput) {
        titleInput.addEventListener('blur', function() {
            validateTitle(this, 'title-error');
        });
    }

    if (cityInput) {
        cityInput.addEventListener('blur', function() {
            validateTextOnly(this, 'city-error');
        });
    }

    if (stateInput) {
        stateInput.addEventListener('blur', function() {
            validateTextOnly(this, 'state-error');
        });
    }

    if (countryInput) {
        countryInput.addEventListener('blur', function() {
            validateTextOnly(this, 'country-error');
        });
    }

    if (pincodeInput) {
        pincodeInput.addEventListener('blur', function() {
            validatePincode(this, 'pincode-error');
        });
    }

    document.querySelectorAll('.co-author-email').forEach(input => {
        input.addEventListener('blur', function() {
            validateEmail(this, null);
        });
    });

    document.getElementById('paper-submission-form').addEventListener('submit', function(e) {
        let isValid = true;

        const verificationInput = document.getElementById('verification_answer');
        if (!verificationInput.value.trim()) {
            verificationInput.classList.add('is-invalid');
            document.getElementById('verification-error').style.display = 'block';
            isValid = false;
            verificationInput.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        } else {
            verificationInput.classList.remove('is-invalid');
            document.getElementById('verification-error').style.display = 'none';
        }

        const declarations = document.querySelectorAll('.declaration-checkbox');
        const allDeclarationsChecked = [...declarations].every(input => input.checked);
        if (!allDeclarationsChecked) {
            document.getElementById('declaration-error').style.display = 'block';
            isValid = false;
        } else {
            document.getElementById('declaration-error').style.display = 'none';
        }

        if (!validateTextOnly(mainDesignationInput, 'author_main_designation-error')) isValid = false;
        if (!validateEmail(mainEmailInput, 'author_main_email-error')) isValid = false;
        if (!validatePhoneNumber(mainMobileInput)) isValid = false;

        if (!validateTitle(titleInput, 'title-error')) isValid = false;

        if (!validateTextOnly(cityInput, 'city-error')) isValid = false;
        if (!validateTextOnly(stateInput, 'state-error')) isValid = false;
        if (!validateTextOnly(countryInput, 'country-error')) isValid = false;
        if (!validatePincode(pincodeInput, 'pincode-error')) isValid = false;

        document.querySelectorAll('.co-author-email').forEach(input => {
            if (input.value && !validateEmail(input, null)) isValid = false;
        });

        const fileInput = document.querySelector('input[name="paper_file"]');
        const file = fileInput.files[0];

        if (file) {
            const fileType = file.name.split('.').pop().toLowerCase();
            if (fileType !== 'doc' && fileType !== 'docx') {
                alert('Please upload a .doc or .docx file only.');
                isValid = false;
            }

            if (file.size > 10 * 1024 * 1024) {
                alert('File size must be less than 10MB.');
                isValid = false;
            }
        }

        const plagiarismInput = document.querySelector('input[name="plagiarism_report"]');
        const aiInput = document.querySelector('input[name="ai_report"]');
        [
            [plagiarismInput, false],
            [aiInput, false],
        ].forEach(([input, required]) => {
            const report = input.files[0];
            if (required && !report) {
                input.classList.add('is-invalid');
                isValid = false;
            }
            if (report) {
                const fileType = report.name.split('.').pop().toLowerCase();
                if (fileType !== 'pdf' || report.size > 10 * 1024 * 1024) {
                    alert('Reports must be PDF files smaller than 10MB.');
                    input.classList.add('is-invalid');
                    isValid = false;
                }
            }
        });

        if (!isValid) {
            e.preventDefault();

            navigateToErrorStep(e);
        }
    });

    /* ===== STEP WIZARD NAVIGATION ===== */
    let currentStep = 1;
    const totalSteps = 3;
    const stepNames = ['Paper Information', 'Author Details', 'Review & Submit'];

    function initStepWizard() {
        updateStepUI();

        document.getElementById('prevBtn').addEventListener('click', function() {
            if (currentStep > 1) {
                currentStep--;
                updateStepUI();
            }
        });

        document.getElementById('nextBtn').addEventListener('click', function() {

            const currentStepElement = document.getElementById(`step-${currentStep}`);
            const requiredFields = currentStepElement.querySelectorAll('[required]');

            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.checkValidity()) {
                    field.reportValidity();
                    isValid = false;
                }
            });

            if (!isValid) {
                return;
            }

            currentStep++;
            updateStepUI();
        });
    }

    function updateStepUI() {
        for (let i = 1; i <= totalSteps; i++) {
            const el = document.getElementById(`step-${i}`);
            el.classList.remove('step-active');
            el.style.display = 'none';
        }

        const currentEl = document.getElementById(`step-${currentStep}`);
        currentEl.style.display = 'block';
        requestAnimationFrame(() => {
            currentEl.classList.add('step-active');
        });

        document.querySelectorAll('.step-item').forEach((item, index) => {
            const stepNum = index + 1;
            item.classList.remove('active', 'completed');
            const circle = item.querySelector('.step-circle');
            const numSpan = circle.querySelector('.step-num');

            if (stepNum === currentStep) {
                item.classList.add('active');
                numSpan.textContent = stepNum;
            } else if (stepNum < currentStep) {
                item.classList.add('completed');
                numSpan.textContent = '✓';
            } else {
                numSpan.textContent = stepNum;
            }
        });

        document.querySelectorAll('.step-connector').forEach((connector, index) => {
            if (index + 1 < currentStep) {
                connector.classList.add('completed');
            } else {
                connector.classList.remove('completed');
            }
        });

        const headerEl = document.querySelector('.step-header');
        headerEl.innerHTML = `<i class="bi bi-${currentStep}-circle me-2"></i> Step ${currentStep} of ${totalSteps}: ${stepNames[currentStep - 1]}`;

        document.getElementById('prevBtn').style.display = currentStep === 1 ? 'none' : 'inline-flex';
        document.getElementById('nextBtn').style.display = currentStep === totalSteps ? 'none' : 'inline-flex';
        document.getElementById('submitBtn').style.display = currentStep === totalSteps ? 'inline-flex' : 'none';
        updateSubmitButton();

        const topEl = document.querySelector('.step-progress-wrapper');
        if (topEl) {
            topEl.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    function updateSubmitButton() {
        const submitButton = document.getElementById('submitBtn');
        const declarations = document.querySelectorAll('.declaration-checkbox');
        submitButton.disabled = ![...declarations].every(input => input.checked);
    }

    document.querySelectorAll('.declaration-checkbox').forEach(input => {
        input.addEventListener('change', function() {
            updateSubmitButton();
            if ([...document.querySelectorAll('.declaration-checkbox')].every(item => item.checked)) {
                document.getElementById('declaration-error').style.display = 'none';
            }
        });
    });

    function navigateToErrorStep(e) {
        const invalidFields = document.querySelectorAll('.is-invalid, .invalid-phone');
        if (invalidFields.length === 0) return;

        const firstInvalid = invalidFields[0];
        const allSteps = [1, 2, 3];

        for (const step of allSteps) {
            const stepEl = document.getElementById(`step-${step}`);
            if (stepEl && stepEl.contains(firstInvalid)) {
                currentStep = step;
                updateStepUI();

                setTimeout(() => {
                    firstInvalid.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }, 450);
                break;
            }
        }
    }
}
</script>
@endsection

@push('scripts')
@endpush
