@extends('layouts.app')

@section('content')
<style>
    .current-issue-container {
        display: flex;
        justify-content: space-between;
        gap: 30px;
        flex-wrap: wrap;
        background-color: #ffffff;
        padding: 20px;
    }

    .left-sidebar {
        flex: 0 0 250px;
    }

    .main-content {
        flex: 1;
        min-width: 600px;
    }

    .right-sidebar {
        flex: 0 0 250px;
    }

    .box {
        background-color: #ffffff;
        border: 1px solid #00004d;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        width: 100%;
        box-sizing: border-box;
    }

    .box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
    }

    .box-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #00004d;
        margin-bottom: 15px;
        border-bottom: 2px solid #cc7a00;
        padding-bottom: 10px;
    }

    .box ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .box ul li {
        margin-bottom: 10px;
    }

    .box ul li a {
        text-decoration: none;
        color: #000000;
        display: block;
        padding: 5px;
        transition: color 0.3s ease, background-color 0.3s ease;
    }

    .box ul li a:hover {
        color: #ffffff;
        background-color: #cc7a00;
    }

    .page-title,
    .issue-header {
        animation: fadeIn 1s ease-in-out;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #00004d;
        margin-bottom: 10px;
    }

    .issue-header {
        font-size: 1.4rem;
        font-weight: bold;
        color: #003300;
        margin-bottom: 25px;
        border-bottom: 2px solid #00cc00;
        padding-bottom: 10px;
    }

    .paper-details {
        font-size: 0.95rem;
        line-height: 1.6;
        color: #000000;
    }

    .paper-details .detail-row {
        margin-bottom: 8px;
    }

    .paper-details .detail-row strong {
        color: #00004d;
    }

    .issn-box {
        text-align: center;
        padding: 20px;
        background-color: #ffffff;
        border: 1px solid #00004d;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .issn-box:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
    }

    .issn-box img {
        max-width: 100%;
        height: auto;
    }

    .blinking-button {
        display: block;
        width: 100%;
        padding: 15px;
        text-align: center;
        text-decoration: none;
        font-size: 1.2rem;
        font-weight: bold;
        color: #000000;
        background-color: #00cc00;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        animation: blink 1s linear infinite, pop 0.3s ease-in-out;
        transition: background-color 0.3s ease;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .blinking-button:hover {
        background-color: #003300;
        animation: none;
        transform: scale(1.05);
    }

    /* Button Styles */
    .btn-action-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #ddd;
    }

    .btn-pdf {
        background-color: #6248f4;
        border: 1px solid #6248f4;
        color: white;
        padding: 8px 20px;
        font-size: 0.9rem;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-pdf:hover {
        background-color: #5038d4;
        border-color: #5038d4;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-abstract {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: white;
        padding: 8px 15px;
        font-size: 0.875rem;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .btn-abstract:hover {
        background-color: #138496;
        border-color: #117a8b;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-certificate {
        background-color: #28a745;
        border: 1px solid #28a745;
        color: white;
        padding: 8px 20px;
        font-size: 0.9rem;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
    }

    .btn-certificate:hover {
        background-color: #218838;
        border-color: #1e7e34;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Modal Styles */
    .custom-modal .modal-content {
        border-radius: 10px;
        border: 2px solid #00004d;
    }

    .custom-modal .modal-header {
        background-color: #00004d;
        color: white;
        border-bottom: 2px solid #cc7a00;
    }

    .custom-modal .modal-title {
        font-weight: bold;
    }

    .custom-modal .btn-close {
        filter: invert(1);
    }

    .custom-modal .modal-body {
        padding: 0;
        background-color: #f8f9fa;
    }

    .pdf-viewer {
        width: 100%;
        height: 80vh;
        border: none;
    }

    .abstract-content {
        padding: 20px;
        max-height: 70vh;
        overflow-y: auto;
        line-height: 1.6;
        background: white;
        border-radius: 5px;
        margin: 10px;
    }

    .certificate-image {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.7;
            transform: scale(0.98);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInFromLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .two-column-layout {
        display: flex;
        gap: 30px;
        width: 100%;
    }

    .two-column-layout .left-column {
        flex: 0 0 280px;
    }

    .two-column-layout .right-column {
        flex: 1;
        min-width: 800px;
        max-width: calc(100% - 310px);
    }

    .partner-box {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 5px;
        border-left: 4px solid #00004d;
        margin-bottom: 15px;
    }

    .partner-name {
        font-weight: bold;
        color: #00004d;
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .issue-content-box {
        animation: slideInFromLeft 0.8s ease-out;
        border-radius: 8px;
    }

    .issue-content-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
    }

    .issue-content-title {
        font-size: 1.4rem;
        font-weight: bold;
        color: #00004d;
        margin-bottom: 5px;
    }

    .abstract-section {
        margin: 15px 0;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 5px;
        border: 1px dashed #ddd;
    }

    .abstract-section strong {
        color: #00004d;
        display: block;
        margin-bottom: 8px;
        font-size: 1rem;
    }

    .abstract-section p {
        margin: 0;
        text-align: justify;
        line-height: 1.6;
    }

    .downloads-info {
        font-size: 0.95rem;
        color: #666;
        padding: 10px 0;
    }

    .downloads-info strong {
        color: #00004d;
    }

    @media (max-width: 1200px) {
        .two-column-layout {
            flex-direction: column;
            gap: 20px;
        }

        .two-column-layout .left-column,
        .two-column-layout .right-column {
            flex: 1;
            width: 100%;
            min-width: 100%;
            max-width: 100%;
        }
    }

    @media (max-width: 992px) {
        .current-issue-container {
            flex-direction: column;
            gap: 20px;
            padding: 15px;
        }

        .left-sidebar,
        .main-content,
        .right-sidebar {
            flex: 1;
            width: 100%;
            min-width: 100%;
        }

        .page-title {
            font-size: 1.5rem;
            text-align: center;
        }

        .issue-header {
            font-size: 1.2rem;
        }

        .box {
            padding: 15px;
        }

        .box-title {
            font-size: 1.1rem;
        }

        .btn-action-group {
            flex-direction: column;
        }

        .btn-action-group .btn {
            width: 100%;
            margin-bottom: 5px;
            text-align: center;
        }

        .blinking-button {
            font-size: 1rem;
            padding: 12px;
        }
    }

    @media (max-width: 576px) {
        .current-issue-container {
            padding: 10px;
            gap: 15px;
        }

        .page-title {
            font-size: 1.3rem;
        }

        .issue-header {
            font-size: 1.1rem;
        }

        .box {
            padding: 12px;
            margin-bottom: 15px;
        }

        .paper-details {
            font-size: 0.85rem;
        }

        .blinking-button {
            font-size: 0.9rem;
            padding: 10px;
        }

        .btn-pdf,
        .btn-certificate {
            padding: 8px 15px;
            font-size: 0.85rem;
        }
    }
</style>

<div class="current-issue-container">
    <div class="two-column-layout">
        <!-- Left Column (Sidebar) -->
        <div class="left-column">
            <a href="{{ url('/submit-paper') }}" class="blinking-button">
                SUBMIT PAPER
            </a><br>

            <div class="box">
                <div class="box-title">Call for Paper</div>
                <ul>
                    <li>
                        <a href="{{ route('submit.paper') }}">Submit your research paper</a>
                    </li>
                </ul>
            </div>

            <div class="box" style="margin-bottom: 0;">
                <div class="box-title">Indexing Partners</div>

                <div style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">

                    @forelse($partners as $partner)
                    <a href="{{ $partner->url }}"
                        target="_blank"
                        style="display: inline-block;">

                        <img src="{{ asset('storage/app/public/' . $partner->icon) }}"
                            alt="Partner Icon"
                            style="width:40px; height:40px; object-fit:contain; border-radius:8px; border:1px solid #ddd; padding:5px; background:#fff;">
                    </a>
                    @empty
                    <p>No Index Partners Found</p>
                    @endforelse

                </div>
            </div>

            <br>

            <div class="box">
                <div class="box-title">Downloads</div>
                <ul>
                    <li><a href="https://docs.google.com/document/d/1Z8bpXSTGNcpDuV3F1wpgzWM5pLVHY1X0/edit?usp=sharing" target="_blank">Research Paper Format</a></li>
                    <li><a href="#">Copyright Permission Form and Undertaking Form</a></li>
                </ul>
            </div>
        </div>

        <!-- Right Column (Main Content) -->
        <div class="right-column">
            <h1 class="page-title">Current Issues</h1>

            @if(isset($issues) && $issues->count())
            @php
            $groupedIssues = $issues->groupBy(function($issue) {
            return 'Volume ' . $issue->volume . ', Issue ' . $issue->number;
            });
            @endphp

            @foreach($groupedIssues as $volumeIssue => $issuesInGroup)
            <h2 class="issue-header">
                {{ $volumeIssue }}
                ({{ \Carbon\Carbon::parse($issuesInGroup->first()->publish_date)->format('F Y') }})
            </h2>

            @foreach($issuesInGroup as $issue)
            <div class="box issue-content-box">
                <div class="box-title">
                    <strong>{{ $issue->title }}</strong>
                </div>

                <div class="paper-details">
                    <!-- Partner Information -->
                    <div class="partner-box">
                        <div class="detail-row">
                            <strong>Registration ID:</strong> {{ $issue->registration_id ?? 'N/A' }}
                        </div>
                        <div class="detail-row">
                            <strong>Published Paper ID:</strong> {{ $issue->published_paper_id ?? 'N/A' }}
                        </div>
                    </div>

                    <!-- Issue Metadata -->
                    <div class="detail-row">
                        <strong>Year:</strong> {{ $issue->year }} |
                        <strong>Volume:</strong> {{ $issue->volume }} |
                        <strong>Issue:</strong> {{ $issue->number }}
                    </div>
                    <div class="detail-row">
                        <strong>Country:</strong> {{ $issue->country ?? 'N/A' }}
                    </div>
                    <div class="detail-row">
                        <strong>DOI:</strong> {{ $issue->crossref_doi_member_id ?? 'N/A' }}
                    </div>
                    <div class="detail-row">
                        <strong>Page No:</strong> {{ $issue->page_no ?? 'N/A' }} |
                        <strong>Approved eISSN:</strong> {{ $issue->approved_eissn ?? 'N/A' }}
                    </div>

                    <!-- Abstract -->
                    @if($issue->abstract)
                    <div class="abstract-section">
                        <strong>Abstract:</strong>
                        <p>{{ $issue->abstract }}</p>
                    </div>
                    @endif

                    <!-- Downloads Information -->
                    <div class="downloads-info">
                        <strong>Downloads:</strong> {{ str_pad($issue->downloads_count, 5, '0', STR_PAD_LEFT) }}

                        @if($issue->published_paper_pdf && Storage::disk('public')->exists($issue->published_paper_pdf))
                        @php
                        $fileSize = Storage::disk('public')->size($issue->published_paper_pdf);
                        $fileSizeFormatted = $fileSize >= 1048576
                        ? round($fileSize / 1048576, 2) . ' MB'
                        : round($fileSize / 1024, 2) . ' KB';
                        @endphp
                        <span style="margin-left: 20px;">
                            <strong>File Size:</strong> {{ $fileSizeFormatted }}
                        </span>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="btn-action-group">
                        @if($issue->published_paper_pdf && Storage::disk('public')->exists($issue->published_paper_pdf))
                        {{-- FIXED: Use the proper download route that increments counter --}}
                        <a href="{{ route('issues.download', $issue->id) }}" class="btn-pdf" target="_blank">
                            📄 Download PDF
                        </a>
                        @endif

                        @if($issue->paper_certificate && Storage::disk('public')->exists('certificates/' . $issue->paper_certificate))
                        <button type="button" class="btn-certificate" data-bs-toggle="modal" data-bs-target="#certificateModal{{ $issue->id }}">
                            🏆 View Certificate
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Certificate Modal -->
            @if($issue->paper_certificate && Storage::disk('public')->exists('certificates/' . $issue->paper_certificate))
            <div class="modal fade custom-modal" id="certificateModal{{ $issue->id }}" tabindex="-1" aria-labelledby="certificateModalLabel{{ $issue->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="certificateModalLabel{{ $issue->id }}">Certificate - {{ $issue->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @php
                            $certificateUrl = asset('storage/certificates/' . $issue->paper_certificate);
                            $isPdf = pathinfo($issue->paper_certificate, PATHINFO_EXTENSION) === 'pdf';
                            @endphp

                            @if($isPdf)
                            <iframe src="{{ $certificateUrl }}" class="pdf-viewer" frameborder="0"></iframe>
                            @else
                            <img src="{{ $certificateUrl }}" alt="Certificate" class="certificate-image">
                            @endif

                            <div class="text-center mt-3">
                                <a href="{{ $certificateUrl }}" class="btn-certificate" download target="_blank">
                                    📥 Download Certificate
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            @endforeach
            @else
            <div class="box">
                <h3>No Current Issues Available</h3>
                <p>There are no issues published yet. Please check back later for the latest issues.</p>
                @if(Auth::check() && Auth::user()->isAdmin())
                <a href="{{ route('admin.issues.create') }}" class="btn-pdf">Create New Issue</a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>


<script>
    // Add click tracking for PDF downloads
    document.addEventListener('DOMContentLoaded', function() {
        // Track PDF downloads
        const pdfLinks = document.querySelectorAll('a.btn-pdf[href*="/issues/"]');

        pdfLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // The download counter will be incremented by the controller
                // This is just for frontend confirmation if needed
                console.log('Download tracking initiated for:', this.href);
            });
        });
    });
</script>
@endsection