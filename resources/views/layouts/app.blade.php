<!DOCTYPE html>
<html lang="en">

<head>
    @stack('styles')
    <meta charset="UTF-8">
    <title>@yield('title', 'BJDD - Journal')</title>
    @stack('head')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('public/assets/img/logo.jpg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .main-card {
            max-width: 1200px;
            margin: 0px auto;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .journal-header img {
            max-height: 200px;
        }

        .header-top-bar {
            background: #063623;
            color: #fff;
            padding: 6px 18px;
            font-size: 13px;
            font-weight: 600;
            min-height: 42px;
        }

        .header-main-area {
            background: #fff;
            padding: 8px 15px;
            border-bottom: 1px solid #ddd;
        }

        .header-logo {
            max-height: 115px;
            width: auto;
        }

        .journal-main-title {
            font-size: 26px;
            font-weight: 800;
            color: #111;
            margin: 0 0 8px;
            line-height: 1.2;
            letter-spacing: .3px;
        }

        .journal-stats-row {
            color: #c47d18;
            font-weight: 700;
            font-size: 15px;
            margin-bottom: 6px;
        }

        .journal-categories-row {
            color: #c47d18;
            font-weight: 700;
            font-size: 15px;
        }

        .submit-box {
            width: 92px;
            height: 105px;
            border: 2px solid #555;
            background: #fff;
            color: #c47d18;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            justify-content: center;
            align-items: center;
            line-height: 1.15;
            text-align: center;
            transition: .3s;
        }

        .submit-box:hover {
            background: #fafafa;
        }

        .header-bottom-bar {
            background: #063623;
            color: #fff;
            padding: 6px 20px;
            font-size: 14px;
            font-weight: 700;
        }

        .navbar-nav {
            margin: auto;
        }

        .navbar .nav-link {
            color: #fff !important;
            font-weight: 500;
            padding: 10px 15px !important;
            border-radius: 4px;
            margin: 0 2px;
            transition: all 0.3s ease;
        }

        .navbar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2) !important;
        }

        .navbar .nav-link.active {
            background-color: #ffc107 !important;
            color: #000 !important;
        }

        .publisher-section {
            background-color: #2b265e;
            color: white;
            padding: 30px 0;
        }

        .publisher-title {
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 20px;
        }

        .publisher-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .publisher-info {
            margin-bottom: 20px;
        }

        .policy-content {
            display: none;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-top: 20px;
        }

        .social-icon {
            width: 24px;
            height: 24px;
            margin: 0 6px;
            transition: .3s;
        }

        .social-icon:hover {
            transform: scale(1.1);
        }

        .visitor-counter-wrap {
            display: flex;
            justify-content: center;
            margin: 22px 0 10px;
        }

        .visitor-counter {
            display: inline-flex;
            flex-direction: column;
            min-width: 172px;
            padding: 9px 16px 10px;
            border: 1px solid #263142;
            border-radius: 4px;
            background: #202936;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .14);
            text-align: center;
        }

        .visitor-counter-label {
            color: #c47d18;
            font-size: .82rem;
            font-weight: 800;
            letter-spacing: .01em;
            line-height: 1.3;
        }

        .visitor-counter-label i {
            margin-right: 5px;
        }

        .visitor-counter-value {
            display: block;
            margin-top: 4px;
            color: #fff;
            font-size: 1rem;
            line-height: 1.3;
        }

        @media (max-width: 430px) {
            .visitor-counter {
                min-width: 160px;
                padding-right: 13px;
                padding-left: 13px;
            }
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }

            100% {
                opacity: 1;
            }
        }

        .btn-blink {
            animation: blink 1.5s infinite;
        }
    </style>
</head>

<body>

    <div class="card main-card">
        <div class="card-body p-0">

            <header>

                <!-- Top Green Bar -->
                <div class="header-top-bar d-flex flex-column flex-md-row justify-content-between align-items-center">

                    <div class="d-flex gap-4">
                        <span>editor@bjddjournal.org</span>
                        <span>+91 8600071634, +91 98903 82132</span>
                    </div>

                    <div class="mt-1 mt-md-0">
                        Open-Access, Transparent Peer-Reviewed, Refereed
                    </div>

                </div>

                <!-- Main Header -->
                <div class="header-main-area">

                    <div class="container-fluid px-2">

                        <div class="row align-items-center g-0">

                            <!-- Logo -->
                            <div class="col-lg-2 col-md-2 text-center text-md-start">

                                <img src="{{ asset('public/assets/img/logo.jpg') }}"
                                    alt="BJDD Logo"
                                    class="header-logo">

                            </div>

                            <!-- Center Content -->
                            <div class="col-lg-8 col-md-8 text-center">
                                <h1 class="journal-main-title">
                                    BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE
                                </h1>

                                <div class="journal-stats-row d-flex flex-wrap justify-content-center gap-4">

                                    <span>ISSN: 3139-1486 (Online)</span>

                                    <span>Impact Factor : 6.21</span>

                                    <span>ESTD Year : 2025</span>

                                </div>

                                <div class="journal-categories-row d-flex flex-wrap justify-content-center gap-4">

                                    <span>Bi-monthly</span>

                                    <span>Multilingual</span>

                                    <span>Academic Research</span>

                                    <span>Multidisciplinary</span>

                                </div>

                            </div>

                            <!-- Submit Paper -->
                            <!-- <div class="col-lg-2 col-md-2 d-flex justify-content-center justify-content-lg-end align-items-center">
                                <a href="{{ route('submit.paper') }}" class="submit-box">
                                    Submit<br>Paper
                                </a>
                            </div> -->

                        </div>

                    </div>

                </div>

                <!-- Bottom Green Strip -->
                <!-- <div class="header-bottom-bar">
                    Important Announcement
                </div> -->

            </header>
            <br>
            <marquee style="background-color: #2b265e; color: #fff; padding: 5px 0; font-size: 16px; font-weight: bold;">
                *** Important Announcement: Call for Papers! Submissions are now open for the upcoming issue. Please visit the "Submit Paper" section to learn more. ***
            </marquee>


            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                        <ul class="navbar-nav">

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    About
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('about-journal') }}">
                                            About the Journal
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('call-for-papers') }}">
                                            Call For Papers
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('policy') }}">
                                            Policy
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('editors-reviewers') ? 'active' : '' }}" href="{{ route('editors-reviewers') }}">Editorial Board</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle"
                                    href="#"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Publication
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="publicationDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('current-issue') }}">
                                            Current Issue
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('archive') }}">
                                            Archives
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('authors') ? 'active' : '' }}" href="{{ route('authors') }}">
                                    Authors
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('blogs') ? 'active' : '' }}"
                                    href="{{ route('blogs') }}">
                                    Blogs
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact Us</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}" href="{{ route('faq') }}">FAQs</a>
                            </li>

                            <a class="btn btn-warning ms-2 py-2 px-4 btn-blink" href="{{ route('submit.paper') }}">
                                Submit Paper
                            </a>


                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container my-4">
                @yield('content')
            </div>
            <footer style="background:#1f2937;color:#fff;margin-top:50px;">

                <div class="container py-3">

                    <div class="row gy-4">

                        <!-- Logo -->
                        <div class="col-lg-3 col-md-6">

                            <img src="{{ asset('public/assets/img/bjdd logo.png') }}"
                                style="width:110px;margin-bottom:15px;">

                            <h5 style="font-weight:700;">
                                BJDD Journal
                            </h5>

                            <p style="color:#d1d5db;line-height:1.6;font-size:14px;margin-bottom:0;">
                                Bodhivruksha Journal of Diverse Discipline is an
                                open-access, peer-reviewed multidisciplinary
                                research journal published by Eagle Leap Publication.
                            </p>

                        </div>

                        <!-- Contact -->
                        <div class="col-lg-3 col-md-6">

                            <h5 style="margin-bottom:12px;font-weight:700;font-size:18px;"> Contact
                            </h5>

                            <ul class="list-unstyled mb-0" style="line-height:1.8;">

                                <li>
                                    <i class="bi bi-envelope-fill me-2 text-warning"></i>
                                    <a href="mailto:editor@bjddjournal.org"
                                        style="color:#d1d5db;text-decoration:none;">
                                        editor@bjddjournal.org
                                    </a>
                                </li>

                                <li>
                                    <i class="bi bi-telephone-fill me-2 text-warning"></i>
                                    +91 8600071634
                                </li>

                                <li>
                                    <i class="bi bi-telephone-fill me-2 text-warning"></i>
                                    +91 9890382132
                                </li>

                                <li>
                                    <i class="bi bi-geo-alt-fill me-2 text-warning"></i>
                                    Pune, Maharashtra, India
                                </li>

                            </ul>

                        </div>

                        <!-- Useful Links -->
                        <div class="col-lg-3 col-md-6">

                            <h5 style="margin-bottom:12px;font-weight:700;font-size:18px;"> Useful Links
                            </h5>

                            <ul class="list-unstyled mb-0" style="line-height:1.8;">

                                <li>
                                    <a href="{{ route('home') }}"
                                        class="text-decoration-none text-light">
                                        Home
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('about-journal') }}"
                                        class="text-decoration-none text-light">
                                        About Journal
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('editors-reviewers') }}"
                                        class="text-decoration-none text-light">
                                        Editorial Board
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('policy') }}"
                                        class="text-decoration-none text-light">
                                        Publication Policy
                                    </a>
                                </li>

                            </ul>

                        </div>

                        <!-- Downloads -->
                        <div class="col-lg-3 col-md-6">

                            <h5 style="margin-bottom:12px;font-weight:700;font-size:18px;"> Downloads
                            </h5>

                            <ul class="list-unstyled mb-0" style="line-height:1.8;">
                                <li>
                                    <a href="https://docs.google.com/document/d/1Z8bpXSTGNcpDuV3F1wpgzWM5pLVHY1X0/edit?usp=sharing&ouid=107421336101958810940&rtpof=true&sd=true"
                                        target="_blank"
                                        class="text-decoration-none text-light">
                                        Research Paper Format
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                        class="text-decoration-none text-light">
                                        Copyright Form
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                        class="text-decoration-none text-light">
                                        Undertaking Form
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('faq') }}"
                                        class="text-decoration-none text-light">
                                        FAQs
                                    </a>
                                </li>

                            </ul>

                        </div>

                    </div>

                    <hr style="border-color:#374151;">

                    <div class="visitor-counter-wrap">
                        <div class="visitor-counter" aria-label="Total visitors">
                            <span class="visitor-counter-label"><i class="bi bi-eye" aria-hidden="true"></i>Total Visitors:</span>
                            <span class="visitor-counter-value">{{ \App\Models\VisitorCounter::formatIndian((int) ($visitorCount ?? 0)) }}</span>
                        </div>
                    </div>

                    <div class="text-center mt-3">

                        <h5 style="margin-bottom:12px;font-size:18px;">
                            Follow Us
                        </h5>

                        <a href="https://www.facebook.com/profile.php?id=61581012112879" target="_blank">
                            <img src="{{ asset('public/assets/img/face.webp') }}"
                                class="social-icon">
                        </a>

                        <a href="https://www.instagram.com/bjdd_journal/" target="_blank">
                            <img src="{{ asset('public/assets/img/instagram.webp') }}"
                                class="social-icon">
                        </a>

                        <a href="https://whatsapp.com/channel/0029Vb6IASSDZ4LZurhPte04" target="_blank">
                            <img src="{{ asset('public/assets/img/whats.png') }}"
                                class="social-icon">
                        </a>

                        <a href="https://chat.whatsapp.com/KBeW5fB7m8mIEgt23aCNb9" target="_blank">
                            <img src="{{ asset('public/assets/img/community.png') }}"
                                class="social-icon">
                        </a>

                    </div>

                </div>

                <div style="background:#111827;padding:12px;text-align:center;font-size:14px;color:#d1d5db;">

                    © {{ date('Y') }} <strong>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD)</strong><br>

                    Published by <strong>Eagle Leap Publication</strong>. All Rights Reserved.

                </div>

            </footer>

        </div>
    </div>

    <div id="policy-container" class="container policy-content">
        <button type="button" class="btn-close float-end" aria-label="Close" onclick="hidePolicy()"></button>
        <div id="policy-content"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</body>
</html>
