@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color: #00004d; color: white;">
                    <h5 class="mb-0">Edit Current Issue & Journal Details</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ route('admin.current-issue.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">Current Publication Details</h6>

                                <div class="mb-3">
                                    <label for="volume" class="form-label">Volume</label>
                                    <input type="text" class="form-control" id="volume" name="volume"
                                        value="{{ old('volume', $currentIssue->volume ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="issue" class="form-label">Issue</label>
                                    <input type="text" class="form-control" id="issue" name="issue"
                                        value="{{ old('issue', $currentIssue->issue ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="month_year" class="form-label">Month – Year</label>
                                    <input type="text" class="form-control" id="month_year" name="month_year"
                                        value="{{ old('month_year', $currentIssue->month_year ?? '') }}" required>
                                    <div class="form-text">Format: September – October 2025</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-primary">Journal Information</h6>

                                <div class="mb-3">
                                    <label for="e_issn" class="form-label">e-ISSN</label>
                                    <input type="text" class="form-control" id="e_issn" name="e_issn"
                                        value="{{ old('e_issn', $currentIssue->e_issn ?? '') }}" required>
                                    <div class="form-text">e.g., Applied / Under Process or 1234-5678</div>
                                </div>

                                <div class="mb-3">
                                    <label for="last_submission_date" class="form-label">Last Submission Date</label>
                                    <input type="date" class="form-control" id="last_submission_date" name="last_submission_date"
                                        value="{{ old('last_submission_date', $currentIssue->last_submission_date ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="home_cover" class="form-label">
                                        Home Cover Image (JPG, JPEG, PNG | Max 2MB)
                                    </label>

                                    <input type="file"
                                        class="form-control"
                                        id="home_cover"
                                        name="home_cover"
                                        accept=".jpg,.jpeg,.png">

                                    <!-- <div class="mt-2">
                                        <img src="{{ asset('storage/app/public/home-cover.png') }}"
                                            alt="Current Home Cover"
                                            style="width:150px; height:auto; border-radius:8px;">
                                    </div> -->
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="background-color: #00004d; border: none;">Update Journal Details</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection