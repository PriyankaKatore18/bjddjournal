@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f4f7fb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .cfp-hero {
        background: linear-gradient(135deg, #0f172a, #1e3a8a);
        color: #fff;
        padding: 40px 30px;
        border-radius: 16px;
        margin-bottom: 25px;
    }

    .cfp-hero h2 {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .section-card {
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        transition: 0.3s ease;
    }

    .section-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    }

    .section-title {
        font-size: 20px;
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
        padding: 6px 12px;
        background: #e0f2fe;
        color: #0369a1;
        border-radius: 20px;
        font-size: 12px;
        margin: 4px 4px 4px 0;
    }

    .info-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 15px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #16a34a, #15803d);
        color: #fff;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 10px;
        border: none;
        transition: 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        color: #fff;
    }
</style>

<div class="container py-4">

    <!-- HERO -->
    <div class="cfp-hero text-center">
        <h2>Submit Your Research Paper for the Upcoming Issue</h2>
        <p>
            BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD) invites researchers,
            academicians, educators, professionals, scholars, and students to submit
            original and unpublished manuscripts for publication.
        </p>
    </div>

    <!-- ABOUT -->
    <div class="section-card">
        <div class="section-title">About BJDD Call for Papers</div>

        <p class="text-muted-custom">
            BJDD is a <strong>Peer-Reviewed, Open Access, Multidisciplinary, and Multilingual Academic Journal</strong>
            dedicated to promoting quality research and scholarly communication across diverse disciplines.
        </p>
    </div>

    <!-- AREAS -->
    <div class="section-card">
        <div class="section-title">Areas of Submission</div>

        <div>
            <span class="badge-tag">Arts & Humanities</span>
            <span class="badge-tag">Social Sciences</span>
            <span class="badge-tag">Commerce & Management</span>
            <span class="badge-tag">Education</span>
            <span class="badge-tag">Library & Information Science</span>
            <span class="badge-tag">Computer Science & IT</span>
            <span class="badge-tag">Science & Technology</span>
            <span class="badge-tag">Law & Governance</span>
            <span class="badge-tag">Agriculture</span>
            <span class="badge-tag">Environmental Studies</span>
            <span class="badge-tag">Health Sciences</span>
            <span class="badge-tag">Interdisciplinary Research</span>
            <span class="badge-tag">Emerging Research Areas</span>
        </div>
    </div>

    <!-- MANUSCRIPTS -->
    <div class="section-card">
        <div class="section-title">Types of Manuscripts Accepted</div>

        <div class="row">
            <div class="col-md-4">
                <ul class="text-muted-custom">
                    <li>Original Research Articles</li>
                    <li>Review Papers</li>
                    <li>Case Studies</li>
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="text-muted-custom">
                    <li>Short Communications</li>
                    <li>Conceptual Papers</li>
                    <li>Scholarly Essays</li>
                </ul>
            </div>
            <div class="col-md-4">
                <ul class="text-muted-custom">
                    <li>Technical Papers</li>
                    <li>Book Reviews</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- HIGHLIGHTS -->
    <div class="section-card">
        <div class="section-title">Journal Highlights</div>

        <div class="info-box">
            <p class="text-muted-custom mb-1">✓ Peer-Reviewed Publication</p>
            <p class="text-muted-custom mb-1">✓ Open Access Journal</p>
            <p class="text-muted-custom mb-1">✓ Multidisciplinary Scope</p>
            <p class="text-muted-custom mb-1">✓ Multilingual Publication (English, Hindi & Marathi)</p>
            <p class="text-muted-custom mb-1">✓ Fast Review Process</p>
            <p class="text-muted-custom mb-1">✓ E-Certificate for Authors</p>
            <p class="text-muted-custom mb-1">✓ Online Publication</p>
            <p class="text-muted-custom mb-1">✓ DOI Facility Available (Optional)</p>
        </div>
    </div>

    <!-- GUIDELINES -->
    <div class="section-card">
        <div class="section-title">Submission Guidelines</div>

        <ul class="text-muted-custom">
            <li>Manuscripts must be original and unpublished.</li>
            <li>Submit in MS Word (.doc/.docx) format.</li>
            <li>Plagiarism should not exceed the prescribed limit.</li>
            <li>Follow BJDD paper format and author guidelines.</li>
            <li>Submissions accepted in English, Hindi, or Marathi.</li>
        </ul>
    </div>

    <!-- INFO TABLE -->
    <div class="section-card">
        <div class="section-title">Publication Information</div>

        <table class="table table-bordered">
            <tr>
                <th>Publication Frequency</th>
                <td>Bi-Monthly (6 Issues Per Year)</td>
            </tr>
            <tr>
                <th>Submission Status</th>
                <td><span class="badge bg-success">Open</span></td>
            </tr>
            <tr>
                <th>Review Process</th>
                <td>Peer Reviewed</td>
            </tr>
            <tr>
                <th>Publication Mode</th>
                <td>Online</td>
            </tr>
            <tr>
                <th>Processing Charges</th>
                <td>₹900 (India) / $14 (International)</td>
            </tr>
        </table>
    </div>

    <!-- CTA -->
    <div class="section-card text-center" style="background: linear-gradient(135deg,#1e3a8a,#0f172a); color:#fff;">
        <h4 class="mb-3">Publish Your Research with BJDD</h4>

        <p class="text-muted-custom" style="color:#e5e7eb;">
            Share your knowledge with the global academic community and get published in a peer-reviewed journal.
        </p>

        <a href="{{ route('submit.paper') }}" class="btn-submit mt-2">
            Submit Your Paper
        </a>
    </div>

</div>

@endsection