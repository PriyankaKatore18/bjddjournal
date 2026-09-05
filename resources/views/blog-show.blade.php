@extends('layouts.app')

@section('title', $blog->display_title . ' | BJDD Journal')

@section('content')

<style>
    .blog-detail-page {
        max-width: 980px;
        margin: 0 auto;
        padding: 18px 0 10px;
        color: #16251f;
    }

    .blog-back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        color: #06452d;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        transition: color .2s ease, transform .2s ease;
    }

    .blog-back-link:hover {
        color: #b06d05;
        transform: translateX(-2px);
    }

    .blog-article {
        overflow: hidden;
        border: 1px solid #dce7df;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 14px 34px rgba(25, 42, 34, .09);
        animation: blogDetailEnter .58s ease both;
    }

    .blog-article-header {
        padding: 32px 34px 26px;
        background: linear-gradient(135deg, #fff 0%, #f7fbf8 64%, #fff8ea 100%);
        border-bottom: 1px solid #e2eee7;
    }

    .blog-kicker {
        display: inline-block;
        margin-bottom: 10px;
        color: #b06d05;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0;
    }

    .blog-article-title {
        max-width: 860px;
        margin: 0;
        color: #073d2a;
        font-size: 38px;
        font-weight: 800;
        line-height: 1.24;
    }

    .blog-article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 16px;
        color: #5e6f69;
        font-size: 14px;
        font-weight: 700;
    }

    .blog-article-meta span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .blog-featured-image {
        width: 100%;
        height: auto;
        max-height: none;
        display: block;
        object-fit: contain;
        background: #f8fbf9;
        border-bottom: 1px solid #e2eee7;
    }

    .blog-article-body {
        padding: 34px;
        color: #2f403a;
        font-size: 16px;
        line-height: 1.68;
    }

    .blog-article-body p {
        margin: 0 0 12px;
    }

    .blog-article-body h1,
    .blog-article-body h2,
    .blog-article-body h3,
    .blog-article-body h4 {
        margin: 26px 0 10px;
        color: #073d2a;
        font-weight: 800;
        line-height: 1.28;
    }

    .blog-article-body h1:first-child,
    .blog-article-body h2:first-child,
    .blog-article-body h3:first-child,
    .blog-article-body h4:first-child {
        margin-top: 0;
    }

    .blog-article-body h2 {
        font-size: 24px;
    }

    .blog-article-body h3,
    .blog-article-body h4 {
        font-size: 20px;
    }

    .blog-article-body ul,
    .blog-article-body ol {
        margin: 4px 0 18px;
        padding-left: 24px;
    }

    .blog-article-body li {
        margin-bottom: 6px;
        padding-left: 2px;
        line-height: 1.6;
    }

    .blog-article-body li::marker {
        color: #b06d05;
    }

    .blog-article-body img {
        max-width: 100%;
        height: auto;
        margin: 10px 0 20px;
        border-radius: 8px;
    }

    .blog-article-footer {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        padding: 24px 34px 34px;
        border-top: 1px solid #e5eee8;
    }

    .blog-footer-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 6px;
        background: #06452d;
        color: #fff;
        padding: 11px 18px;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        transition: background .22s ease, transform .22s ease;
    }

    .blog-footer-button:hover {
        background: #b06d05;
        color: #fff;
        transform: translateY(-1px);
    }

    @keyframes blogDetailEnter {
        from {
            opacity: 0;
            transform: translateY(16px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .blog-back-link,
        .blog-article,
        .blog-footer-button {
            animation: none;
            transition: none;
        }
    }

    @media (max-width: 768px) {
        .blog-article-header {
            padding: 26px 20px 22px;
        }

        .blog-article-title {
            font-size: 28px;
        }

        .blog-article-body {
            padding: 24px 20px;
            font-size: 16px;
        }

        .blog-article-footer {
            padding: 22px 20px 26px;
        }
    }
</style>

<div class="blog-detail-page">
    <a class="blog-back-link" href="{{ route('blogs') }}">
        <i class="bi bi-arrow-left" aria-hidden="true"></i>
        Back to Blogs
    </a>

    <article class="blog-article">
        <header class="blog-article-header">
            <span class="blog-kicker">BJDD Journal Blog</span>
            <h1 class="blog-article-title">{{ $blog->full_title }}</h1>

            <div class="blog-article-meta">
                <span><i class="bi bi-calendar3" aria-hidden="true"></i>{{ optional($blog->created_at)->format('d M Y') ?: 'BJDD Blog' }}</span>
                <span><i class="bi bi-bookmark" aria-hidden="true"></i>Academic Blog</span>
            </div>
        </header>

        @if($blog->image)
            <img class="blog-featured-image" src="{{ asset('storage/app/public/'.$blog->image) }}" alt="{{ $blog->display_title }}">
        @endif

        <div class="blog-article-body">
            {!! $blog->article_html !!}
        </div>

        <footer class="blog-article-footer">
            <a class="blog-footer-button" href="{{ route('blogs') }}">
                <i class="bi bi-arrow-left" aria-hidden="true"></i>
                Back to Blogs
            </a>
        </footer>
    </article>
</div>

@endsection
