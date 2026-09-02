@extends('layouts.app')

@push('styles')
<style>
    body {
        background: #f9fbfd;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    .about-bjdd-section {
        padding: 70px 20px;
        max-width: 1100px;
        margin: 0 auto;
    }

    .about-bjdd-section .section-title {
        font-size: 2.2rem;
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 25px;
        text-align: center;
        letter-spacing: 0.5px;
        position: relative;
    }

    .about-bjdd-section .section-title::after {
        content: "";
        display: block;
        width: 80px;
        height: 3px;
        background: #007bff;
        margin: 10px auto 0;
        border-radius: 2px;
    }

    .about-bjdd-section .section-paragraph {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 50px;
        text-align: justify;
        padding: 0 10px;
    }


    .journal-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-top: 25px;
    }

    .info-card {
        background: #f7f7fb;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
        transition: .3s;
        border: 1px solid #ececf3;
    }

    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
    }

    .info-card i {
        width: 42px;
        height: 42px;
        background: #fff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2f2b8f;
        font-size: 18px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, .05);
        flex-shrink: 0;
    }

    .info-content {
        flex: 1;
    }

    .info-content span {
        display: block;
        font-size: 13px;
        color: #777;
        margin-bottom: 4px;
    }

    .info-content h6 {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
        color: #2f2b8f;
        line-height: 1.5;
    }

    .info-content a {
        color: #d9534f;
        text-decoration: none;
        font-weight: 600;
    }

    .info-content a:hover {
        text-decoration: underline;
        color: #1d5d99;
    }

    .info-content a:hover {
        text-decoration: underline;
    }

    .full-card {
        grid-column: 1/-1;
    }

    @media(max-width:991px) {
        .journal-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width:767px) {
        .journal-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width:576px) {
        .about-bjdd-section {
            padding: 50px 15px;
        }
    }

    @media (max-width:991px) {

        .journal-layout {
            flex-direction: column !important;
        }

        .journal-layout section {
            flex: 0 0 100% !important;
            width: 100% !important;
        }

        .journal-grid {
            grid-template-columns: repeat(2, 1fr);
        }

    }



    @media (max-width:768px) {

        .about-bjdd-section {
            padding: 20px 10px;
        }

        .journal-layout {

            flex-direction: column !important;
            gap: 25px;

        }

        .journal-layout section {

            width: 100% !important;
            flex: 0 0 100% !important;

        }


        .journal-grid {

            grid-template-columns: 1fr !important;

        }

        .full-card {

            grid-column: auto;

        }

        .info-card {

            padding: 16px;

        }

        .info-content h6 {

            font-size: 15px;

        }

        section[style*="max-width: 1100px"]>div:last-child {

            grid-template-columns: 1fr !important;

        }

    }


    .hero-banner {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
    }

    .hero-image {
        width: 100%;
        height: 560px;
        object-fit: cover;
        display: block;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: rgba(8, 25, 55, .55);
    }

    .hero-content {
        position: absolute;
        top: 35px;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        text-align: center;
        color: #fff;
        z-index: 5;
    }

    .hero-features {
        position: absolute;
        bottom: 90px;
        left: 50%;
        transform: translateX(-50%);
        width: 92%;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        z-index: 10;
    }

    .hero-buttons {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 18px;
        z-index: 10;
    }

    @media(max-width:768px) {

        .hero-image {
            height: auto;
            min-height: 1200px;
        }

        .hero-content {
            top: 30px;
        }

        .hero-title {
            font-size: 26px;
        }

        .hero-subtitle {
            font-size: 17px;
        }

        .hero-features {

            position: absolute;

            top: 180px;

            left: 50%;

            transform: translateX(-50%);

            width: 90%;

            grid-template-columns: 1fr;

            gap: 15px;

            bottom: auto;
        }

        .hero-features>div {

            padding: 18px !important;
        }

        .hero-features img {

            height: 40px !important;
        }

        .hero-features h3 {

            font-size: 18px !important;
        }

        .hero-buttons {

            position: absolute;

            bottom: 30px;

            left: 50%;

            transform: translateX(-50%);

            width: 90%;

            display: flex;

            flex-direction: column;

            gap: 12px;
        }

        .hero-buttons a {

            width: 100%;

            text-align: center;
        }

        .hero-content {
            width: 95%;
            top: 20px;
            padding: 0 10px;
        }

        .hero-content h1 {
            font-size: 20px !important;
            line-height: 1.4;
            white-space: normal;
            word-break: break-word;
        }

        .hero-content p {
            font-size: 14px !important;
            line-height: 1.6;
            white-space: normal;
            word-break: break-word;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('content')
<div class="container">


    <section class="about-bjdd-section">
        <div class="hero-banner">

            <img src="{{ asset('storage/app/public/background-image.jpg') }}"
                class="hero-image">

            <div class="hero-overlay"></div>

            <div class="hero-content">

                <h1 style="
                    font-size:46px;
                    font-weight:800;
                    margin-bottom:15px;
                    letter-spacing:.5px;
                    ">
                    BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE
                </h1>

                <p style="
                    font-size:22px;
                    font-weight:600;
                    margin-bottom:15px;
                    ">

                    ISSN :
                    3139-1486 (Online)

                    &nbsp;&nbsp;&nbsp;&nbsp;

                    ESTD :
                    2025

                </p>


            </div>

            <div class="hero-features">

                <div style="
                    background:#24158f;
                    padding:30px 20px;
                    border-radius:12px;
                    text-align:center;
                    border:4px solid #fff;
                    ">

                    <img src="{{ asset('public/assets/img/peer1.png') }}"
                        style="height:45px;">

                    <h3 style="
                        margin-top:18px;
                        color:#fff;
                        font-size:22px;
                        font-weight:700;
                        ">

                        Peer Reviewed

                    </h3>

                </div>

                <div style="
                background:#24158f;
                padding:30px 20px;
                border-radius:12px;
                text-align:center;
                border:4px solid #fff;
                ">

                    <img src="{{ asset('public/assets/img/open.png') }}"
                        style="height:45px;">

                    <h3 style="
                    margin-top:18px;
                    color:#fff;
                    font-size:22px;
                    font-weight:700;
                    ">

                        Open Access

                    </h3>

                </div>

                <div style="
                background:#24158f;
                padding:30px 20px;
                border-radius:12px;
                text-align:center;
                border:4px solid #fff;
                ">

                    <img src="{{ asset('public/assets/img/multi.png') }}"
                        style="height:45px;">

                    <h3 style="
                    margin-top:18px;
                    color:#fff;
                    font-size:22px;
                    font-weight:700;
                    ">

                        Multidisciplinary

                    </h3>

                </div>

                <div style="
                    background:#24158f;
                    padding:30px 20px;
                    border-radius:12px;
                    text-align:center;
                    border:4px solid #fff;
                    ">

                    <img src="{{ asset('public/assets/img/multiple.png') }}"
                        style="height:45px;">

                    <h3 style="
                        margin-top:18px;
                        color:#fff;
                        font-size:20px;
                        font-weight:700;
                        line-height:1.5;
                    ">

                        Multiple Languages

                        <br>

                        (English, Hindi, Marathi)

                    </h3>

                </div>

            </div>

            <div class="hero-buttons">

                <a href="{{ route('current-issue') }}"
                    style="
                padding:14px 28px;
                background:#fff;
                color:#1d5d99;
                border-radius:8px;
                font-weight:700;
                text-decoration:none;
                ">

                    View Current Issue →

                </a>

                <a href="{{ route('submit.paper') }}"
                    style="
                padding:14px 28px;
                background:#0d6efd;
                color:#fff;
                border-radius:8px;
                font-weight:700;
                text-decoration:none;
                ">

                    Submit Your Research

                </a>

            </div>

        </div>

    </section>

    <div class="journal-layout" style="
        display:flex;
        gap:30px;
        align-items:flex-start;
        margin-top:30px;
        justify-content:space-between;
        ">


        <section style="
            flex:0 0 72%;
            font-family: Arial, sans-serif;
            background-color:#ffffff;
            overflow:auto;
            ">
            <h2 style="text-align: left; margin: 0 0 20px 0; font-size: 2em; color: #333;">
                Journal Information
            </h2>

            <div class="journal-grid">

                <!-- Full Width -->
                <div class="info-card full-card">
                    <i class="fas fa-book-open"></i>

                    <div class="info-content">
                        <span>Journal Title</span>
                        <h6>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</h6>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-id-card"></i>

                    <div class="info-content">
                        <span>ISSN</span>
                        <h6>3139-1486</h6>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-globe"></i>

                    <div class="info-content">
                        <span>Website</span>

                        <h6>
                            <a href="https://bjddjournal.org">
                                bjddjournal.org
                            </a>
                        </h6>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-envelope"></i>

                    <div class="info-content">
                        <span>Email</span>

                        <h6>
                            <a href="mailto:editor@bjddjournal.org">
                                editor@bjddjournal.org
                            </a>
                        </h6>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-calendar-alt"></i>

                    <div class="info-content">
                        <span>Publication Frequency</span>
                        <h6>Bi-Monthly</h6>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-language"></i>

                    <div class="info-content">
                        <span>Language</span>
                        <h6>English, Hindi, Marathi</h6>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-university"></i>

                    <div class="info-content">
                        <span>Publisher</span>
                        <h6>Eagle Leap Publication</h6>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-award"></i>

                    <div class="info-content">
                        <span>Impact Factor</span>
                        <h6>6.21</h6>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-layer-group"></i>

                    <div class="info-content">
                        <span>Journal Status</span>
                        <h6>National Level Open Access</h6>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-file-alt"></i>

                    <div class="info-content">
                        <span>Research Availability</span>
                        <h6>Available Online</h6>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-rupee-sign"></i>

                    <div class="info-content">
                        <span>Publication Charges</span>
                        <h6>₹900 / $14</h6>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-clock"></i>

                    <div class="info-content">
                        <span>Review Timeline</span>
                        <h6>3 Days Review<br>2 Days Publication</h6>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-user-tie"></i>

                    <div class="info-content">
                        <span>Editor-in-Chief</span>
                        <h6>Dr. Laxman K Gouda</h6>
                    </div>
                </div>

                <div class="info-card">
                    <i class="fas fa-users"></i>

                    <div class="info-content">
                        <span>Editorial Board</span>
                        <h6>
                            <a href="{{ route('editors-reviewers') }}">
                                Click Here →
                            </a>
                        </h6>
                    </div>
                </div>

                <div class="info-card full-card">
                    <i class="fas fa-layer-group"></i>

                    <div class="info-content">
                        <span>Indexing Partners</span>

                        <h6 style="margin-top:6px;">
                            @php
                            $indexPartners = \App\Models\IndexPartner::all();
                            @endphp

                            @if($indexPartners->count())
                            @foreach($indexPartners as $partner)
                            <a href="{{ $partner->url }}" target="_blank" style="color:#2f2b8f; text-decoration:none; font-weight:600;">
                                {{ $partner->name }}
                            </a>@if(!$loop->last), @endif
                            @endforeach
                            @else
                            Not Available
                            @endif
                        </h6>
                    </div>
                </div>

                <div class="info-card full-card">
                    <i class="fas fa-tags"></i>

                    <div class="info-content">
                        <span>Related Subjects</span>

                        <h6 id="subjectsText" style="line-height:1.9; font-weight:600; color:#d9534f;">
                            Multidisciplinary Studies, Social Sciences, Humanities,
                            Commerce & Management, Economics, Education,
                            Political Science, Sociology, History,
                            Geography, Language & Literature, Library & Information Science,
                            Environmental Studies, Computer Science, Information Technology,
                            Artificial Intelligence, Engineering & Technology, Agricultural Sciences,
                            Life Sciences, Physical Sciences, Health Sciences,
                            Law, Public Administration
                        </h6>

                        <a href="javascript:void(0);" id="toggleSubjects"
                            style="color:#1d5d99; font-weight:700; display:inline-block; margin-top:10px;">
                            View More
                        </a>
                    </div>
                </div>

            </div>
        </section>



        <section style="
            flex:0 0 25%;
            border:1px solid #ddd;
            border-radius:10px;
            background:#fff;
            padding:20px;
            text-align:center;
            color:#006400;
            position:sticky;
            top:20px;
            height:fit-content;
            ">

            <div style="width:100%;">

                @php
                try {
                if (\Illuminate\Support\Facades\Schema::hasTable('current_issues')) {
                $currentIssue = \App\Models\CurrentIssue::where('is_active', true)->first();
                } else {
                $currentIssue = null;
                }

                $homeCover = \App\Models\BusinessSetting::where('key', 'home_cover')->first();

                } catch (Exception $e) {
                $currentIssue = null;
                }
                @endphp

                <div style="margin-bottom:20px;">

                    @if($homeCover && $homeCover->value)
                    <img src="{{ asset('storage/app/public/' . $homeCover->value) }}"
                        alt="Home Cover"
                        style="
                        width:100%;
                        max-width:250px;
                        object-fit:cover;
                        border-radius:8px;
                    ">
                    @else
                    <img src="{{ asset('storage/app/public/home-cover.png') }}"
                        alt="Default Home Cover"
                        style="
                        width:100%;
                        max-width:250px;
                        object-fit:cover;
                        border-radius:8px;
                    ">
                    @endif

                </div>

                @if($currentIssue)
                <p style="
                margin:10px 0 20px;
                font-size:18px;
                font-weight:bold;
                color:#006400;
            ">
                    Volume {{ $currentIssue->volume }},
                    Issue {{ $currentIssue->issue }}
                    ({{ $currentIssue->month_year }})
                </p>
                @else
                <p style="
                margin:10px 0 20px;
                font-size:18px;
                font-weight:bold;
                color:#006400;
            ">
                    Volume 1, Issue 3
                    (September – October 2025)
                </p>
                @endif

                <hr style="
                border:none;
                height:1px;
                background:#ddd;
                margin:20px 0;
            ">

                <p style="
                margin-bottom:25px;
                font-size:16px;
                color:#006400;
            ">
                    Authors are invited to submit their research work for consideration in the current issue.
                </p>

                <a href="{{ route('submit.paper') }}"
                    style="
                    background-color:#6cff47;
                    color:#000;
                    font-weight:bold;
                    text-decoration:none;
                    padding:15px 25px;
                    border-radius:5px;
                    display:inline-block;
                ">
                    SUBMIT PAPER
                </a>

            </div>

        </section>

    </div>

    <section style="font-family: 'Segoe UI', sans-serif; margin: 60px auto; max-width: 1100px;">

        @php
        try {
        if (\Illuminate\Support\Facades\Schema::hasTable('current_issues')) {
        $currentIssue = \App\Models\CurrentIssue::where('is_active', true)->first();
        } else {
        $currentIssue = null;
        }
        } catch (Exception $e) {
        $currentIssue = null;
        }
        @endphp



        <div style="text-align: center; margin-bottom: 50px;">
            <h2 style="
            font-size: 2.4rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        ">
                Journal Publication Details
            </h2>

            <div style="
            width: 90px;
            height: 4px;
            background: linear-gradient(to right, #2563eb, #06b6d4);
            margin: 0 auto 18px;
            border-radius: 10px;
        "></div>

            <p style="
            color: #64748b;
            font-size: 16px;
            margin: 0;
        ">
            </p>
        </div>

        <div style="
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 28px;
    ">

            <div style="
            background: linear-gradient(180deg, #ffffff, #f8fbff);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            border-top: 5px solid #2563eb;
            transition: 0.3s ease;
        ">
                <h4 style="
                margin: 0 0 14px;
                font-size: 18px;
                font-weight: 700;
                color: #1e293b;
            ">
                    Published By
                </h4>

                <p style="
                margin: 0;
                color: #475569;
                font-size: 15px;
                line-height: 1.9;
            ">
                    BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE – Publisher: Eagle Leap Publication.
                    Address: Mule Chawl, Dattawadi, Akurdi, Pune – 411033, Maharashtra, India
                </p>
            </div>

            <div style="
            background: linear-gradient(180deg, #ffffff, #f8fbff);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            border-top: 5px solid #2563eb;
        ">
                <h4 style="margin: 0 0 14px; font-size: 18px; font-weight: 700; color: #1e293b;">
                    Current Publication
                </h4>

                <p style="margin: 0; color: #475569; font-size: 15px; line-height: 1.8;">
                    @if($currentIssue)
                    Volume {{ $currentIssue->volume }}, Issue {{ $currentIssue->issue }} ({{ $currentIssue->month_year }})
                    @else
                    Volume 1, Issue 3 (September – October 2025)
                    @endif
                </p>
            </div>

            <div style="
            background: linear-gradient(180deg, #ffffff, #f8fbff);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            border-top: 5px solid #2563eb;
        ">
                <h4 style="margin: 0 0 14px; font-size: 18px; font-weight: 700; color: #1e293b;">
                    e-ISSN
                </h4>

                <p style="margin: 0; color: #475569; font-size: 15px; line-height: 1.8;">
                    @if($currentIssue && $currentIssue->e_issn)
                    {{ $currentIssue->e_issn }}
                    @else
                    Applied / Under Process
                    @endif
                </p>
            </div>

            <div style="
            background: linear-gradient(180deg, #ffffff, #f8fbff);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            border-top: 5px solid #2563eb;
        ">
                <h4 style="margin: 0 0 14px; font-size: 18px; font-weight: 700; color: #1e293b;">
                    Language Edition
                </h4>

                <p style="margin: 0; color: #475569; font-size: 15px; line-height: 1.8;">
                    Multilingual (English / Hindi / Marathi)
                </p>
            </div>

            <div style="
            background: linear-gradient(180deg, #ffffff, #f8fbff);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            border-top: 5px solid #2563eb;
        ">
                <h4 style="margin: 0 0 14px; font-size: 18px; font-weight: 700; color: #1e293b;">
                    Frequency
                </h4>

                <p style="margin: 0; color: #475569; font-size: 15px; line-height: 1.8;">
                    Bi-Monthly (6 Issues Per Year)
                </p>
            </div>

            <div style="
            background: linear-gradient(180deg, #ffffff, #f8fbff);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            border-top: 5px solid #2563eb;
        ">
                <h4 style="margin: 0 0 14px; font-size: 18px; font-weight: 700; color: #1e293b;">
                    Discipline
                </h4>

                <p style="margin: 0; color: #475569; font-size: 15px; line-height: 1.8;">
                    Multidisciplinary
                </p>
            </div>

            <div style="
            background: linear-gradient(180deg, #ffffff, #f8fbff);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            border-top: 5px solid #2563eb;
        ">
                <h4 style="margin: 0 0 14px; font-size: 18px; font-weight: 700; color: #1e293b;">
                    Last Submission Date
                </h4>

                <p style="margin: 0; color: #475569; font-size: 15px; line-height: 1.8;">
                    @if($currentIssue && $currentIssue->last_submission_date)
                    {{ \Carbon\Carbon::parse($currentIssue->last_submission_date)->format('jS F Y') }}
                    @else
                    25th October 2025
                    @endif
                </p>
            </div>

            <div style="
            background: linear-gradient(180deg, #ffffff, #f8fbff);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            border-top: 5px solid #2563eb;
        ">
                <h4 style="margin: 0 0 14px; font-size: 18px; font-weight: 700; color: #1e293b;">
                    Paper Processing Charges
                </h4>

                <p style="
                margin: 0;
                color: #475569;
                font-size: 15px;
                line-height: 2;
            ">
                    ₹900 INR (Indian Authors)<br>
                    $14 (Foreign Authors)<br>
                    Inclusive of Online Publication & Certificate
                </p>
            </div>

        </div>



    </section>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const text = document.getElementById("subjectsText");
    const btn = document.getElementById("toggleSubjects");

    let expanded = false;

    function limitToFirst6() {
        const items = text.innerText.split(",");
        const first6 = items.slice(0, 6).join(", ");
        text.innerText = first6;
    }

    // store original text
    const fullText = text.innerText;

    // initial state → first 6 only
    const items = fullText.split(",");
    text.innerText = items.slice(0, 6).join(", ");

    btn.addEventListener("click", function () {
        if (!expanded) {
            text.innerText = fullText;
            btn.innerText = "View Less";
        } else {
            text.innerText = items.slice(0, 6).join(", ");
            btn.innerText = "View More";
        }
        expanded = !expanded;
    });
});
</script>
@endsection