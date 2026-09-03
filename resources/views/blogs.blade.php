@extends('layouts.app')

@section('title', 'Blogs | BJDD Journal')

@section('content')

<style>
    .blogs-page {
        max-width: 1120px;
        margin: 0 auto;
        padding: 18px 0 6px;
        color: #14231d;
    }

    .blogs-header {
        margin-bottom: 28px;
        padding: 30px 30px 28px;
        border: 1px solid #dce7df;
        border-radius: 8px;
        background: linear-gradient(135deg, #ffffff 0%, #f5faf7 58%, #fff8ea 100%);
        animation: blogsFadeUp .65s ease both;
    }

    .blogs-kicker {
        display: inline-flex;
        align-items: center;
        margin-bottom: 10px;
        color: #b06d05;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0;
    }

    .blogs-title {
        margin: 0;
        color: #00004d;
        font-size: 38px;
        font-weight: 800;
        line-height: 1.18;
    }

    .blogs-subtitle {
        max-width: 760px;
        margin: 12px 0 0;
        color: #53645e;
        font-size: 16px;
        line-height: 1.75;
    }

    .blogs-list {
        display: grid;
        gap: 22px;
    }

    .blog-entry {
        display: grid;
        grid-template-columns: minmax(190px, 260px) minmax(0, 1fr);
        gap: 24px;
        padding: 24px;
        border: 1px solid #dce7df;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 12px 28px rgba(25, 42, 34, .08);
        opacity: 0;
        transform: translateY(16px);
        animation: blogsFadeUp .7s ease both;
        animation-delay: var(--delay, 0ms);
        transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
    }

    .blog-entry:hover {
        border-color: #b9d5c5;
        box-shadow: 0 18px 36px rgba(25, 42, 34, .12);
        transform: translateY(-3px);
    }

    .blog-media {
        position: relative;
        min-height: 210px;
        overflow: hidden;
        border-radius: 6px;
        background: #eef6f1;
        aspect-ratio: 4 / 3;
    }

    .blog-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .45s ease;
    }

    .blog-entry:hover .blog-media img {
        transform: scale(1.04);
    }

    .blog-media-placeholder {
        height: 100%;
        display: grid;
        place-items: center;
        padding: 24px;
        color: #06452d;
        text-align: center;
        font-weight: 800;
    }

    .blog-media-placeholder i {
        display: block;
        margin-bottom: 10px;
        color: #b06d05;
        font-size: 34px;
    }

    .blog-body {
        min-width: 0;
    }

    .blog-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 9px;
        color: #62716b;
        font-size: 13px;
        font-weight: 700;
    }

    .blog-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .blog-heading {
        margin: 0 0 12px;
        color: #073d2a;
        font-size: 24px;
        font-weight: 800;
        line-height: 1.35;
    }

    .blog-excerpt {
        margin: 0 0 16px;
        color: #42514c;
        font-size: 15px;
        line-height: 1.8;
    }

    .blog-reader {
        border-top: 1px solid #e5eee8;
        padding-top: 14px;
    }

    .blog-reader summary {
        width: max-content;
        max-width: 100%;
        list-style: none;
        cursor: pointer;
        border-radius: 6px;
        background: #06452d;
        color: #fff;
        padding: 10px 18px;
        font-weight: 800;
        transition: background .25s ease, transform .25s ease;
    }

    .blog-reader summary::-webkit-details-marker {
        display: none;
    }

    .blog-reader summary:hover {
        background: #b06d05;
        transform: translateY(-1px);
    }

    .blog-reader[open] summary {
        margin-bottom: 18px;
        background: #00004d;
    }

    .blog-copy {
        color: #2f3f39;
        font-size: 15px;
        line-height: 1.9;
        animation: blogsSoftReveal .32s ease both;
    }

    .blog-copy p,
    .blog-copy ul,
    .blog-copy ol {
        margin-bottom: 15px;
    }

    .blog-copy h1,
    .blog-copy h2,
    .blog-copy h3,
    .blog-copy h4 {
        margin: 22px 0 10px;
        color: #073d2a;
        font-weight: 800;
        line-height: 1.35;
    }

    .blog-copy img {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
    }

    .blogs-empty {
        padding: 38px 24px;
        border: 1px solid #ead9b8;
        border-radius: 8px;
        background: #fff9ed;
        color: #74531e;
        text-align: center;
        font-weight: 700;
    }

    .blogs-pagination {
        margin-top: 28px;
    }

    .blogs-pagination .pagination {
        justify-content: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .blogs-pagination .page-link {
        border-radius: 6px;
        color: #06452d;
        border-color: #d8e5dc;
        font-weight: 700;
    }

    .blogs-pagination .page-item.active .page-link {
        background: #06452d;
        border-color: #06452d;
    }

    @keyframes blogsFadeUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes blogsSoftReveal {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .blogs-header,
        .blog-entry,
        .blog-copy,
        .blog-media img,
        .blog-reader summary {
            animation: none;
            transition: none;
        }

        .blog-entry {
            opacity: 1;
            transform: none;
        }
    }

    @media (max-width: 768px) {
        .blogs-header {
            padding: 24px 18px;
        }

        .blogs-title {
            font-size: 30px;
        }

        .blog-entry {
            grid-template-columns: 1fr;
            gap: 18px;
            padding: 18px;
        }

        .blog-media {
            min-height: 220px;
        }

        .blog-heading {
            font-size: 21px;
        }
    }
</style>

<div class="blogs-page">
    <header class="blogs-header">
        <span class="blogs-kicker">BJDD Journal</span>
        <h1 class="blogs-title">Blogs</h1>
        <p class="blogs-subtitle">
            Research writing guidance, journal updates, and academic insights for authors, reviewers, and readers.
        </p>
    </header>

    <section class="blogs-list" aria-label="BJDD blog articles">
        @forelse($blogs as $blog)
            @php
                $descriptionHtml = trim($blog->description ?? '');
                $bodyHtml = $descriptionHtml;
                $title = 'BJDD Journal Blog';
                $firstBlock = null;

                if ($descriptionHtml !== '' && preg_match('/<(h[1-6]|p|div)[^>]*>(.*?)<\/\1>/is', $descriptionHtml, $matches)) {
                    $candidate = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($matches[2]))));

                    if ($candidate !== '') {
                        $firstBlock = $candidate;
                        $bodyHtml = preg_replace('/<(h[1-6]|p|div)[^>]*>.*?<\/\1>/is', '', $descriptionHtml, 1);
                    }
                }

                $plainDescription = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($descriptionHtml))));
                $title = $firstBlock ?: \Illuminate\Support\Str::limit($plainDescription ?: $title, 105);
                $bodyPlain = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($bodyHtml ?: $descriptionHtml))));
                $excerpt = \Illuminate\Support\Str::limit($bodyPlain ?: $title, 260);
                $publishedDate = optional($blog->created_at)->format('d M Y');
            @endphp

            <article class="blog-entry" style="--delay: {{ $loop->index * 90 }}ms;">
                <div class="blog-media">
                    @if($blog->image)
                        <img src="{{ asset('storage/app/public/'.$blog->image) }}" alt="{{ $title }}">
                    @else
                        <div class="blog-media-placeholder">
                            <div>
                                <i class="bi bi-journal-richtext" aria-hidden="true"></i>
                                <span>BJDD Journal</span>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="blog-body">
                    <div class="blog-meta">
                        <span><i class="bi bi-calendar3" aria-hidden="true"></i>{{ $publishedDate ?: 'BJDD Blog' }}</span>
                        <span><i class="bi bi-bookmark" aria-hidden="true"></i>Academic Blog</span>
                    </div>

                    <h2 class="blog-heading">{{ $title }}</h2>

                    @if($excerpt)
                        <p class="blog-excerpt">{{ $excerpt }}</p>
                    @endif

                    <details class="blog-reader">
                        <summary>Read Article</summary>
                        <div class="blog-copy">
                            {!! $bodyHtml ?: $descriptionHtml !!}
                        </div>
                    </details>
                </div>
            </article>
        @empty
            <div class="blogs-empty">
                No Blogs Found
            </div>
        @endforelse
    </section>

    @if($blogs->hasPages())
        <nav class="blogs-pagination" aria-label="Blog pagination">
            {{ $blogs->links() }}
        </nav>
    @endif
</div>

@endsection
