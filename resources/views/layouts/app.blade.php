<!DOCTYPE html>
<html lang="en">

<head>
    @php
        $currentRoute = request()->route()?->getName();
        $seoDefaults = [
            'home' => [
                'title' => 'BJDD Journal | Peer-Reviewed Multidisciplinary Research Journal',
                'description' => 'Bodhivruksha Journal of Diverse Discipline (BJDD) is an open-access, peer-reviewed multidisciplinary research journal for original academic research.',
                'keywords' => 'Bodhivruksha Journal, BJDD Journal, multidisciplinary research journal, peer-reviewed journal, open access journal, academic research',
            ],
            'authors' => [
                'title' => 'Authors | BJDD Journal',
                'description' => 'Author guidelines, paper format, submission information, publication charges and copyright resources for BJDD Journal contributors.',
                'keywords' => 'BJDD author guidelines, research paper submission, academic paper format, journal publication, paper submission guidelines',
            ],
            'current-issue' => [
                'title' => 'Current Issue | BJDD Journal',
                'description' => 'Read the latest published research articles from the Bodhivruksha Journal of Diverse Discipline current issue.',
                'keywords' => 'BJDD current issue, latest research articles, multidisciplinary journal issue, published research papers',
            ],
            'archive' => [
                'title' => 'Publication Archive | BJDD Journal',
                'description' => 'Browse the BJDD Journal publication archive by year, volume, issue, title, author and DOI.',
                'keywords' => 'BJDD publication archive, research paper archive, journal volumes, journal issues, academic articles',
            ],
            'archive.issue' => [
                'title' => 'Published Issue | BJDD Journal',
                'description' => 'Explore published research articles and issue information from the BJDD Journal publication archive.',
                'keywords' => 'BJDD journal issue, published research articles, multidisciplinary research papers, journal archive',
            ],
            'article.details' => [
                'title' => 'Research Article | BJDD Journal',
                'description' => 'Read a peer-reviewed open-access research article published by the Bodhivruksha Journal of Diverse Discipline.',
                'keywords' => 'BJDD research article, peer-reviewed article, open access research, multidisciplinary academic paper',
            ],
            'special-issues.index' => [
                'title' => 'Special Issues & Conferences | BJDD Journal',
                'description' => 'Discover BJDD special issues, conference publications and thematic collections of multidisciplinary research.',
                'keywords' => 'BJDD special issue, academic conference publication, multidisciplinary research conference, thematic research collection',
            ],
            'special-issues.show' => [
                'title' => 'Special Issue | BJDD Journal',
                'description' => 'Explore a BJDD Journal special issue and its published conference-associated research articles.',
                'keywords' => 'BJDD special issue articles, conference research papers, published academic research, thematic journal issue',
            ],
            'special-issues.articles.show' => [
                'title' => 'Special Issue Research Article | BJDD Journal',
                'description' => 'Read an open-access research article published in a BJDD Journal special issue.',
                'keywords' => 'special issue research article, BJDD conference paper, open access academic article, peer-reviewed research',
            ],
            'editors-reviewers' => [
                'title' => 'Editorial Board | BJDD Journal',
                'description' => 'Meet the editors and reviewers of the Bodhivruksha Journal of Diverse Discipline.',
                'keywords' => 'BJDD editorial board, journal editors, academic reviewers, peer review team, research journal',
            ],
            'contact' => [
                'title' => 'Contact BJDD Journal',
                'description' => 'Contact the BJDD Journal editorial team for submissions, publication enquiries, peer review and academic research support.',
                'keywords' => 'contact BJDD Journal, journal editorial office, research paper enquiry, publication support',
            ],
            'about-journal' => [
                'title' => 'About BJDD Journal | Bodhivruksha Journal of Diverse Discipline',
                'description' => 'Learn about BJDD Journal, its multidisciplinary scope, open-access model, peer-review process and academic publishing mission.',
                'keywords' => 'about BJDD Journal, Bodhivruksha Journal, multidisciplinary journal scope, open access peer review',
            ],
            'call-for-papers' => [
                'title' => 'Call for Papers | BJDD Journal',
                'description' => 'Submit original research, review papers and multidisciplinary academic studies to the BJDD Journal call for papers.',
                'keywords' => 'BJDD call for papers, submit research paper, academic publication call, multidisciplinary journal submission',
            ],
            'policy' => [
                'title' => 'Publication Policies | BJDD Journal',
                'description' => 'Read BJDD Journal publication ethics, peer review, copyright, privacy, open access and research integrity policies.',
                'keywords' => 'BJDD publication policy, journal ethics, peer review policy, copyright policy, research integrity',
            ],
            'faq' => [
                'title' => 'Frequently Asked Questions | BJDD Journal',
                'description' => 'Find answers about BJDD Journal submissions, peer review, publication, ISSN, DOI, fees and author services.',
                'keywords' => 'BJDD Journal FAQ, paper submission questions, publication fees, peer review FAQ, DOI ISSN journal',
            ],
            'blogs' => [
                'title' => 'Academic Research Blogs | BJDD Journal',
                'description' => 'Read academic publishing, research and multidisciplinary scholarship insights from the BJDD Journal blog.',
                'keywords' => 'BJDD academic blog, research publishing blog, scholarly communication, multidisciplinary research insights',
            ],
            'blogs.show' => [
                'title' => 'Research Blog | BJDD Journal',
                'description' => 'Read research and academic publishing insights from the Bodhivruksha Journal of Diverse Discipline blog.',
                'keywords' => 'BJDD research blog, academic publishing insights, scholarly research article, journal blog',
            ],
            'submit.paper' => [
                'title' => 'Submit a Research Paper | BJDD Journal',
                'description' => 'Submit your original research paper to BJDD Journal, an open-access peer-reviewed multidisciplinary academic journal.',
                'keywords' => 'submit research paper, BJDD paper submission, open access journal submission, multidisciplinary journal authors',
            ],
        ];

        $seoPage = $seoDefaults[$currentRoute] ?? [
            'title' => 'BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD)',
            'description' => 'BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE is an open-access, peer-reviewed multidisciplinary research journal published by Eagle Leap Publication.',
            'keywords' => 'Bodhivruksha Journal, BJDD, academic research journal, peer-reviewed open access journal',
        ];

        $seoTitle = trim($__env->yieldContent('title')) ?: $seoPage['title'];
        $seoDescription = trim($__env->yieldContent('meta_description')) ?: $seoPage['description'];
        $seoKeywords = trim($__env->yieldContent('meta_keywords')) ?: $seoPage['keywords'];
        $seoCanonical = trim($__env->yieldContent('canonical_url')) ?: url()->current();
        $seoType = trim($__env->yieldContent('og_type')) ?: (in_array($currentRoute, ['article.details', 'special-issues.articles.show', 'blogs.show'], true) ? 'article' : 'website');
        $seoImage = asset('assets/img/logo.jpg');

        if ($currentRoute === 'article.details' && isset($publication)) {
            $seoDescription = \Illuminate\Support\Str::limit(strip_tags((string) $publication->abstract), 155) ?: $seoDescription;
            $seoKeywords = trim((string) $publication->keywords) ?: $seoKeywords;
        }

        if ($currentRoute === 'blogs.show' && isset($blog)) {
            $seoDescription = \Illuminate\Support\Str::limit(strip_tags((string) ($blog->excerpt ?: $blog->content)), 155) ?: $seoDescription;
        }

        if ($currentRoute === 'special-issues.show' && isset($specialIssue)) {
            $seoDescription = \Illuminate\Support\Str::limit(strip_tags((string) ($specialIssue->subtitle ?: $specialIssue->about_conference)), 155) ?: $seoDescription;
        }

        if ($currentRoute === 'special-issues.articles.show' && isset($article)) {
            $seoDescription = \Illuminate\Support\Str::limit(strip_tags((string) $article->abstract), 155) ?: $seoDescription;
            $seoKeywords = trim((string) $article->keywords) ?: $seoKeywords;
        }

        $seoStructuredData = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Periodical',
                    '@id' => url('/') . '#journal',
                    'name' => 'BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE',
                    'url' => url('/'),
                    'issn' => ['3139-1486', '3139-9819'],
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => 'Eagle Leap Publication',
                    ],
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => url('/') . '#website',
                    'url' => url('/'),
                    'name' => 'BJDD Journal',
                    'publisher' => ['@id' => url('/') . '#organization'],
                ],
                [
                    '@type' => 'Organization',
                    '@id' => url('/') . '#organization',
                    'name' => 'Eagle Leap Publication',
                    'url' => url('/'),
                    'logo' => $seoImage,
                ],
            ],
        ];
    @endphp

    @stack('styles')
    <meta charset="UTF-8">
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="author" content="BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="{{ $seoCanonical }}">

    <meta property="og:type" content="{{ $seoType }}">
    <meta property="og:site_name" content="BJDD Journal">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    <script type="application/ld+json">@json($seoStructuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>

    @stack('head')
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if(config('services.google.site_verification'))
        <meta name="google-site-verification" content="{{ config('services.google.site_verification') }}">
    @endif

    @if(config('services.google.analytics_id'))
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('services.google.analytics_id') }}');
        </script>
    @endif

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.jpg') }}">

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

        .indexing-partners-footer {
            background: #f4f8f5;
            border-top: 1px solid #dce5df;
            border-bottom: 1px solid #dce5df;
            color: #17221c;
        }

        .indexing-partners-footer h2 {
            color: #06452d;
            font-size: 1.35rem;
            font-weight: 800;
            margin: 0 0 5px;
            text-align: center;
        }

        .indexing-partners-footer-intro,
        .indexing-partners-footer-empty {
            color: #59665f;
            font-size: .95rem;
            margin: 0 0 18px;
            text-align: center;
        }

        .indexing-partners-footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 14px;
            align-items: stretch;
        }

        .indexing-partner-logo-card {
            align-items: center;
            background: #fff;
            border: 1px solid #dce5df;
            border-radius: 7px;
            display: flex;
            justify-content: center;
            min-height: 86px;
            padding: 10px;
            text-decoration: none;
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
        }

        .indexing-partner-logo-card:hover {
            border-color: #c47d18;
            box-shadow: 0 4px 12px rgba(6, 69, 45, .12);
            transform: translateY(-2px);
        }

        .indexing-partner-logo-card img {
            display: block;
            height: 64px;
            max-width: 100%;
            object-fit: contain;
            width: 100%;
        }

        .indexing-partner-logo-card span {
            color: #183c2d;
            font-size: .9rem;
            font-weight: 700;
            text-align: center;
        }

        @media (max-width: 576px) {
            .indexing-partners-footer-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .indexing-partner-logo-card {
                min-height: 78px;
            }

            .indexing-partner-logo-card img {
                height: 58px;
            }
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

                                <img src="{{ asset('assets/img/logo.jpg') }}"
                                    alt="BJDD Logo"
                                    class="header-logo">

                            </div>

                            <!-- Center Content -->
                            <div class="col-lg-8 col-md-8 text-center">
                                <h1 class="journal-main-title">
                                    BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE
                                </h1>

                                <div class="journal-stats-row d-flex flex-wrap justify-content-center gap-4">

                                    <span>ISSN: 3139-1486 (Online) | ISSN: 3139-9819 (Print)</span>

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
                                    <li>
                                        <a class="dropdown-item" href="{{ route('special-issues.index') }}">
                                            Special Issues &amp; Conferences
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
                                <a class="nav-link {{ request()->routeIs('blogs*') ? 'active' : '' }}"
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

                @include('partials.indexing-partners')

                <div class="container py-3">

                    <div class="row gy-4">

                        <!-- Logo -->
                        <div class="col-lg-3 col-md-6">

                            <img src="{{ asset('assets/img/bjdd logo.png') }}"
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
                                    <a href="{{ asset('documents/paper-format.docx') }}"
                                        target="_blank"
                                        rel="noopener"
                                        class="text-decoration-none text-light">
                                        Research Paper Format
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ asset('documents/copyright-licence-to-publish-agreement.pdf') }}"
                                        target="_blank"
                                        rel="noopener"
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
                            <img src="{{ asset('assets/img/face.webp') }}"
                                class="social-icon">
                        </a>

                        <a href="https://www.instagram.com/bjdd_journal/" target="_blank">
                            <img src="{{ asset('assets/img/instagram.webp') }}"
                                class="social-icon">
                        </a>

                        <a href="https://whatsapp.com/channel/0029Vb6IASSDZ4LZurhPte04" target="_blank">
                            <img src="{{ asset('assets/img/whats.png') }}"
                                class="social-icon">
                        </a>

                        <a href="https://chat.whatsapp.com/KBeW5fB7m8mIEgt23aCNb9" target="_blank">
                            <img src="{{ asset('assets/img/community.png') }}"
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
