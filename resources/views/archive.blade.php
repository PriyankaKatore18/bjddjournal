@extends('layouts.app')

@section('content')
<style>
    .archive-container {
        display: flex;
        gap: 30px;
        max-width: 1200px;
        margin: auto;
        padding: 30px 15px;
    }

    .sidebar {
        flex: 0 0 250px;
    }

    .main-content {
        flex: 1;
        min-width: 0;
    }

    .box {
        background-color: #ffffff;
        border: 1px solid #00004d;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
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

    .main-title,
    .issue-header {
        animation: fadeIn 1s ease-in-out;
    }

    .main-title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #00004d;
        margin-bottom: 10px;
    }

    .issue-header {
        font-size: 1.4rem;
        font-weight: bold;
        color: #003300;
        margin-bottom: 15px;
        border-bottom: 2px solid #00cc00;
        padding-bottom: 8px;
    }

    .paper-card {
        background-color: #ffffff;
        border: 1px solid #00004d;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        animation: slideInFromLeft 0.8s ease-out;
    }

    .paper-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
    }

    .paper-title {
        font-size: 1.4rem;
        font-weight: bold;
        color: #00004d;
        margin-bottom: 5px;
    }

    .author-name {
        font-size: 1.1rem;
        color: #003300;
        margin-bottom: 15px;
    }

    .paper-details {
        font-size: 0.9rem;
        line-height: 1.6;
        color: #000000;
    }

    .paper-details .detail-row {
        margin-bottom: 10px;
        padding: 5px 0;
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
    }

    .blinking-button:hover {
        background-color: #003300;
        animation: none;
        transform: scale(1.05);
    }

    /* Certificate Modal Styles */
    .certificate-modal .modal-content {
        border-radius: 10px;
        border: 2px solid #00004d;
    }

    .certificate-modal .modal-header {
        background-color: #00004d;
        color: white;
        border-bottom: 2px solid #cc7a00;
    }

    .certificate-modal .modal-title {
        font-weight: bold;
    }

    .certificate-modal .btn-close {
        filter: invert(1);
    }

    .certificate-modal .modal-body {
        padding: 20px;
        text-align: center;
        background-color: #f8f9fa;
    }

    .certificate-modal .certificate-image {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }

    .certificate-download-btn {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
        padding: 8px 15px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        margin-top: 5px;
    }

    .certificate-download-btn:hover {
        background-color: #218838;
        border-color: #1e7e34;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-primary {
        margin-top: 5px;
    }

    .debug-info {
        font-size: 0.8rem;
        color: #666;
        background: #f8f9fa;
        padding: 5px;
        border-radius: 3px;
        margin-top: 5px;
    }

    .issue-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
    }

    .issue-top {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .year-badge {
        background: #c62828;
        color: #fff;
        padding: 5px 12px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 600;
    }

    .current-badge {
        background: #16a34a;
        color: #fff;
        padding: 5px 12px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 600;
    }

    .issue-body {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .issue-title {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        color: #111827;
    }

    .view-issue-btn {
        border: none;
        background: #c62828;
        color: white;
        padding: 12px 22px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: .3s;
        text-decoration: none;

    }

    .view-issue-btn:hover {
        background: #a91e1e;
    }

    .w-100 {
        width: 100%;
    }

    @media(max-width:768px) {

        .issue-body {
            flex-direction: column;
            align-items: flex-start;
        }

        .view-issue-btn {
            width: 100%;
        }

        .issue-title {
            font-size: 22px;
        }
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

    /* Responsive styles for mobile */
    @media (max-width: 992px) {
        .archive-container {
            flex-direction: column;
            gap: 20px;
            padding: 15px;
        }

        .sidebar,
        .main-content {
            flex: 1;
            width: 100%;
            min-width: 100%;
        }

        .main-title {
            font-size: 1.5rem;
            text-align: center;
        }

        .issue-header {
            font-size: 1.2rem;
        }

        .paper-card {
            padding: 15px;
        }

        .paper-title {
            font-size: 1.2rem;
        }

        .author-name {
            font-size: 1rem;
        }

        .paper-details {
            font-size: 0.85rem;
        }

        .paper-details .detail-row {
            display: flex;
            flex-direction: column;
            margin-bottom: 8px;
        }

        .blinking-button {
            font-size: 1rem;
            padding: 12px;
        }

        .box {
            padding: 15px;
        }

        .box-title {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 576px) {
        .archive-container {
            padding: 10px;
            gap: 15px;
        }

        .main-title {
            font-size: 1.3rem;
        }

        .issue-header {
            font-size: 1.1rem;
        }

        .paper-card {
            padding: 12px;
            margin-bottom: 15px;
        }

        .paper-title {
            font-size: 1.1rem;
        }

        .paper-details {
            font-size: 0.8rem;
        }

        .blinking-button {
            font-size: 0.9rem;
            padding: 10px;
        }

        .box {
            padding: 12px;
            margin-bottom: 15px;
        }

        .abstract-row {
            display: block;
            margin-bottom: 15px;
        }

        .abstract-row strong {
            color: #00004d;
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .abstract-content {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #cc7a00;
            border-radius: 4px;
            line-height: 1.6;
            font-size: 0.9rem;
            color: #333;
            margin-top: 5px;
        }
    }
</style>

<div class="archive-container">
    @php
    $showSidebar = false;
    @endphp

    @if($showSidebar)
    <div class="sidebar">

        <!-- Sidebar Content -->

    </div>
    @endif

    <!-- <div class="box">
        <div class="box-title">Downloads</div>
        <ul>
            <li><a href="https://docs.google.com/document/d/1Z8bpXSTGNcpDuV3F1wpgzWM5pLVHY1X0/edit?tab=t.0">Research Paper Format</a></li>
            <li><a href="#">Copyright Permission Form and Undertaking Form</a></li>
        </ul>
    </div> -->
</div>


<div class="main-content {{ !$showSidebar ? 'w-100' : '' }}">
    <h1 class="main-title">Publication Archive</h1>

    @if($publications->count() > 0)
    @foreach($publications as $volumeIssue => $papers)

    <div class="issue-card">
        <div class="issue-top">
            <span class="year-badge">{{ $papers->first()->year }}</span>

           
        </div>

        <div class="issue-body">
            <div>
                <h3 class="issue-title">
                    {{ $volumeIssue }}
                </h3>
            </div>

            <a href="{{ route('archive.issue', [
                    'volume' => $papers->first()->volume,
                    'issue' => $papers->first()->issue
                ]) }}"
                class="view-issue-btn">
                View Issue
            </a>
        </div>
    </div>

    <!-- <div id="volume-{{ $loop->index }}" style="display: none;">

        @foreach($papers as $paper)
        <div class="paper-card">
            <div class="paper-title">{{ $paper->paper_title }}</div>
            <div class="author-name">{{ $paper->author_name }}</div>

            <div class="paper-details">
                <div class="detail-row">
                    <strong>Registration ID:</strong> {{ $paper->registration_id ?? 'N/A' }} |
                    <strong>Published Paper ID:</strong> {{ $paper->published_paper_id ?? 'N/A' }}
                </div>

                <div class="detail-row">
                    <strong>Year:</strong> {{ $paper->year }} |
                    <strong>Volume:</strong> {{ $paper->volume }} |
                    <strong>Issue:</strong> {{ $paper->issue }}
                </div>

                <div class="detail-row">
                    <strong>Country:</strong> {{ $paper->country ?? 'N/A' }}
                </div>

                <div class="detail-row">
                    <strong>DOI:</strong>
                    @if($paper->crossref_doi)
                    <a href="{{ $paper->crossref_doi }}" target="_blank">
                        {{ $paper->crossref_doi }}
                    </a>
                    @else
                    N/A
                    @endif
                </div>

                @if($paper->abstract)
                <div class="detail-row abstract-row">
                    <strong>Abstract:</strong>
                    <div class="abstract-content">
                        {{ $paper->abstract }}
                    </div>
                </div>
                @endif

                <div class="detail-row">
                    <strong>Page No:</strong> {{ $paper->page_nos ?? 'N/A' }} |
                    <strong>Downloads:</strong> {{ $paper->download_count }}
                </div>

                {{-- PDF View --}}
                @if($paper->paper_pdf)
                <div class="detail-row">
                    <a href="{{ route('publications.viewPdf', $paper->id) }}"
                        class="btn btn-sm btn-primary"
                        target="_blank">
                        Download PDF
                    </a>
                </div>
                @endif

                {{-- Certificate Download --}}
                @if($paper->certificate_path && Storage::disk('public')->exists($paper->certificate_path))
                <div class="detail-row">
                    <a href="{{ asset('storage/' . $paper->certificate_path) }}"
                        class="btn btn-sm certificate-download-btn"
                        target="_blank">
                        Download Certificate
                    </a>
                </div>
                @else
                <div class="debug-info">
                    No certificate available for this paper
                </div>
                @endif
            </div>
        </div>
        @endforeach

    </div> -->

    @endforeach
    @else
    <div class="paper-card">
        <div class="paper-title">No Publications Available</div>
        <div class="paper-details">
            <p>There are no publications in the archive yet. Please check back later.</p>
        </div>
    </div>
    @endif
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Document loaded');

        const publications = document.querySelectorAll('.paper-card');
        publications.forEach((pub, index) => {
            pub.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
<script>
    function toggleVolume(id) {
        let content = document.getElementById(id);
        let icon = document.getElementById("icon-" + id);

        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block";
            icon.innerHTML = "−";
        } else {
            content.style.display = "none";
            icon.innerHTML = "+";
        }
    }
</script>
@endsection