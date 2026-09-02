@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f4f7fb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .bjdd-hero {
        background: linear-gradient(135deg, #0f172a, #1e3a8a);
        color: #fff;
        padding: 70px 30px;
        border-radius: 18px;
        margin-bottom: 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .bjdd-hero h1 {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .bjdd-hero p {
        font-size: 16px;
        opacity: 0.9;
        max-width: 900px;
        margin: 0 auto;
    }

    .section-card {
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
        transition: 0.3s ease;
    }

    .section-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    }

    .section-title {
        font-size: 22px;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 15px;
        border-left: 5px solid #f59e0b;
        padding-left: 10px;
    }

    .text-muted-custom {
        color: #555;
        line-height: 1.7;
        font-size: 15px;
    }

    .badge-tag {
        display: inline-block;
        padding: 5px 12px;
        background: #e0f2fe;
        color: #0369a1;
        border-radius: 20px;
        font-size: 12px;
        margin-right: 6px;
        margin-bottom: 6px;
    }
</style>

<div class="container py-4">

    <!-- HERO SECTION -->
    <div class="bjdd-hero">
        <h1>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</h1>
        <p>
            A peer-reviewed, open-access, multidisciplinary academic journal dedicated to advancing research,
            innovation, and global scholarly communication.
        </p>
    </div>

    <!-- ABOUT SECTION -->
    <div class="section-card">
        <div class="section-title">Our Core Objectives</div>

        <div class="row">
            <div class="col-md-6">
                <ul class="text-muted-custom">
                    <li>Publish high-quality and original research across disciplines.</li>
                    <li>Maintain transparent and fair peer-review system.</li>
                    <li>Promote ethical publishing practices.</li>
                    <li>Encourage interdisciplinary research collaboration.</li>
                    <li>Support young researchers and scholars.</li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="text-muted-custom">
                    <li>Provide global open-access visibility.</li>
                    <li>Encourage innovation and critical thinking.</li>
                    <li>Facilitate knowledge exchange worldwide.</li>
                    <li>Promote evidence-based societal development.</li>
                    <li>Strengthen academic research culture.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- SCOPE -->
    <div class="section-card">
        <div class="section-title">Scope of the Journal</div>

        <p class="text-muted-custom">
            BJDD accepts research across a wide range of disciplines including humanities, science, technology,
            social sciences, management, law, education, and emerging interdisciplinary fields.
        </p>

        <div>
            <span class="badge-tag">Education</span>
            <span class="badge-tag">Social Sciences</span>
            <span class="badge-tag">Psychology</span>
            <span class="badge-tag">Political Science</span>
            <span class="badge-tag">Economics</span>
            <span class="badge-tag">Management</span>
            <span class="badge-tag">Computer Science</span>
            <span class="badge-tag">AI & IT</span>
            <span class="badge-tag">Law</span>
            <span class="badge-tag">Library Science</span>
            <span class="badge-tag">Environmental Studies</span>
            <span class="badge-tag">Agriculture</span>
            <span class="badge-tag">Health Sciences</span>
            <span class="badge-tag">Gender Studies</span>
            <span class="badge-tag">Media Studies</span>
        </div>
    </div>

    <!-- MANUSCRIPT TYPES -->
    <div class="section-card">
        <div class="section-title">Types of Manuscripts Accepted</div>

        <div class="row">
            <div class="col-md-4">
                <ul class="text-muted-custom">
                    <li>Original Research Articles</li>
                    <li>Review Articles</li>
                    <li>Case Studies</li>
                </ul>
            </div>

            <div class="col-md-4">
                <ul class="text-muted-custom">
                    <li>Conceptual Papers</li>
                    <li>Short Communications</li>
                    <li>Technical Notes</li>
                </ul>
            </div>

            <div class="col-md-4">
                <ul class="text-muted-custom">
                    <li>Book Reviews</li>
                    <li>Conference Papers</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- PUBLICATION MODEL -->
    <div class="section-card">
        <div class="section-title">Publication Model</div>

        <div class="row">
            <div class="col-md-6">
                <ul class="text-muted-custom">
                    <li>Peer-Reviewed Journal</li>
                    <li>Open Access Publishing</li>
                    <li>Online Publication</li>
                </ul>
            </div>

            <div class="col-md-6">
                <ul class="text-muted-custom">
                    <li>Multidisciplinary Scope</li>
                    <li>Multilingual Acceptance</li>
                    <li>Bimonthly Issues (6 per year)</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- INDEXING -->
    <div class="section-card">
        <div class="section-title">Indexing & Partners</div>

        <div>
            <span class="badge-tag">Google Scholar</span>
            <span class="badge-tag">ResearchGate</span>
            <span class="badge-tag">EuroPub</span>
            <span class="badge-tag">ISSN India</span>
            <span class="badge-tag">IFS</span>
        </div>
    </div>

    <!-- CTA SECTION -->
    <div class="section-card text-center" style="background: linear-gradient(135deg,#1e3a8a,#0f172a); color:#fff;">
        <div class="section-title" style="color:#fff; border-left-color:#f59e0b;">
            Join the Global Research Community
        </div>

        <p class="text-muted-custom" style="color:#e5e7eb;">
            Publish your research with BJDD and become part of an international academic platform
            dedicated to innovation, excellence, and knowledge sharing.
        </p>

        <a href="{{ route('submit.paper') }}" class="btn btn-warning mt-3 px-4 py-2 fw-bold">
            Submit Your Paper
        </a>
    </div>

</div>

@endsection