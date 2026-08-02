@extends('admin.layouts.app')
@section('title', 'View Contact Submission')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 style="color: #00004d; font-weight: bold;">View Contact Submission</h4>
        <a href="{{ route('admin.contact-submissions.index') }}" class="btn" style="background-color: #00004d; color: #ffffff;">
            &larr; Back to Submissions
        </a>
    </div>

    <div class="card shadow-sm" style="border: 1px solid #00004d;">
        <div class="card-header py-3" style="background-color: #00004d; color: #ffffff;">
            <h5 class="mb-0">Submission Details</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <tr>
                    <th style="background-color: rgba(0, 51, 0, 0.1); width: 200px; color: #00004d;">Name</th>
                    <td>{{ $submission->name }}</td>
                </tr>
                <tr>
                    <th style="background-color: rgba(0, 51, 0, 0.1); color: #00004d;">Email</th>
                    <td>
                        <a href="mailto:{{ $submission->email }}" style="color: #00004d;">
                            {{ $submission->email }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <th style="background-color: rgba(0, 51, 0, 0.1); color: #00004d;">Phone</th>
                    <td>
                        @if($submission->phone)
                            <a href="tel:{{ $submission->phone }}" style="color: #00004d;">
                                {{ $submission->phone }}
                            </a>
                        @else
                            <span style="color: #cc7a00;">Not provided</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th style="background-color: rgba(0, 51, 0, 0.1); color: #00004d;">Subject</th>
                    <td>{{ $submission->subject }}</td>
                </tr>
                <tr>
                    <th style="background-color: rgba(0, 51, 0, 0.1); color: #00004d;">Message</th>
                    <td style="white-space: pre-wrap;">{{ $submission->message }}</td>
                </tr>
                <tr>
                    <th style="background-color: rgba(0, 51, 0, 0.1); color: #00004d;">Submitted At</th>
                    <td>{{ $submission->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer d-flex justify-content-end gap-2" style="background-color: rgba(0, 0, 77, 0.05);">
            <a href="{{ route('admin.contact-submissions.index') }}" class="btn" style="background-color: #00004d; color: #ffffff;">
                Back to List
            </a>
            <form action="{{ route('admin.contact-submissions.destroy', $submission->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="background-color: #cc7a00; color: #000000;" 
                        onclick="return confirm('Are you sure you want to delete this submission?')">
                    Delete Submission
                </button>
            </form>
        </div>
    </div>

    {{-- <!-- Additional Information Section (Collapsible) -->
    <div class="card shadow-sm mt-4" style="border: 1px solid #00004d;">
        <div class="card-header py-3" style="background-color: rgba(0, 0, 77, 0.1); cursor: pointer;" 
             onclick="this.nextElementSibling.classList.toggle('d-none');">
            <h6 class="mb-0" style="color: #00004d;">
                Technical Details ▼
            </h6>
        </div>
        <div class="card-body d-none">
            <table class="table table-sm">
                <tr>
                    <th style="width: 200px; color: #00004d;">IP Address</th>
                    <td>{{ $submission->ip_address }}</td>
                </tr>
                <tr>
                    <th style="color: #00004d;">User Agent</th>
                    <td style="font-size: 0.9rem;">{{ $submission->user_agent }}</td>
                </tr>
            </table>
        </div>
    </div> --}}
</div>

<style>
    .table th {
        border-right: 1px solid #dee2e6;
        font-weight: 600;
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 51, 0, 0.03);
    }
    
    .table-striped tbody tr:hover {
        background-color: rgba(0, 0, 77, 0.05);
    }
    
    .btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
    
    .card-header h6:hover {
        color: #cc7a00 !important;
    }
</style>
@endsection