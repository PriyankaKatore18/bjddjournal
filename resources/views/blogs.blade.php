@extends('layouts.app')

@section('title', 'Blogs | BJDD Journal')

@section('content')

<style>
    .blogs-page {
        max-width: 1120px;
        margin: 0 auto;
        padding: 18px 0 8px;
        color: #14231d;
    }

    .blogs-header {
        margin-bottom: 24px;
        padding: 28px 30px;
        border: 1px solid #dce7df;
        border-radius: 8px;
        background: linear-gradient(135deg, #fff 0%, #f5faf7 60%, #fff8ea 100%);
        animation: blogsFadeUp .55s ease both;
    }

    .blogs-kicker {
        display: inline-block;
        margin-bottom: 8px;
        color: #b06d05;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0;
    }

    .blogs-title {
        margin: 0;
        color: #00004d;
        font-size: 38px;
        font-weight: 800;
        line-height: 1.15;
    }

    .blogs-subtitle {
        max-width: 780px;
        margin: 12px 0 0;
        color: #52625d;
        font-size: 16px;
        line-height: 1.7;
    }

    .blogs-list {
        display: grid;
        gap: 18px;
    }

    .blog-card {
        display: grid;
        grid-template-columns: 230px minmax(0, 1fr);
        gap: 22px;
        padding: 20px;
        border: 1px solid #cfe3d6;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 12px 28px rgba(25, 42, 34, .08);
        opacity: 0;
        transform: translateY(14px);
        animation: blogsFadeUp .62s ease both;
        animation-delay: var(--delay, 0ms);
        transition: border-color .24s ease, box-shadow .24s ease, transform .24s ease;
    }

    .blog-card:hover {
        border-color: #92c8a6;
        box-shadow: 0 18px 34px rgba(25, 42, 34, .12);
        transform: translateY(-3px);
    }

    .blog-thumb-link {
        display: block;
        overflow: hidden;
        border-radius: 6px;
        background: #eef6f1;
        aspect-ratio: 4 / 3;
    }

    .blog-thumb-link img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        transition: transform .42s ease;
    }

    .blog-card:hover .blog-thumb-link img {
        transform: scale(1.04);
    }

    .blog-thumb-placeholder {
        height: 100%;
        display: grid;
        place-items: center;
        color: #06452d;
        font-size: 15px;
        font-weight: 800;
        text-align: center;
    }

    .blog-thumb-placeholder i {
        display: block;
        margin-bottom: 8px;
        color: #b06d05;
        font-size: 32px;
    }

    .blog-card-body {
        display: flex;
        min-width: 0;
        flex-direction: column;
        justify-content: center;
    }

    .blog-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 8px;
        color: #64746f;
        font-size: 13px;
        font-weight: 700;
    }

    .blog-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .blog-card-title {
        margin: 0 0 10px;
        font-size: 24px;
        font-weight: 800;
        line-height: 1.32;
    }

    .blog-card-title a {
        display: -webkit-box;
        overflow: hidden;
        color: #073d2a;
        text-decoration: none;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .blog-card-title a:hover {
        color: #b06d05;
    }

    .blog-excerpt {
        display: -webkit-box;
        overflow: hidden;
        margin: 0 0 16px;
        color: #43534e;
        font-size: 15px;
        line-height: 1.75;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .blog-read-link {
        width: max-content;
        max-width: 100%;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 6px;
        background: #06452d;
        color: #fff;
        padding: 10px 18px;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        transition: background .22s ease, transform .22s ease;
    }

    .blog-read-link:hover {
        background: #b06d05;
        color: #fff;
        transform: translateX(2px);
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
        margin-top: 26px;
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
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .blogs-header,
        .blog-card,
        .blog-thumb-link img,
        .blog-read-link {
            animation: none;
            transition: none;
        }

        .blog-card {
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

        .blog-card {
            grid-template-columns: 1fr;
            gap: 16px;
            padding: 16px;
        }

        .blog-card-title {
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
            <article class="blog-card" style="--delay: {{ $loop->index * 80 }}ms;">
                <a class="blog-thumb-link" href="{{ route('blogs.show', $blog) }}" aria-label="Read {{ $blog->display_title }}">
                    @if($blog->image)
                        <img src="{{ asset('storage/app/public/'.$blog->image) }}" alt="{{ $blog->display_title }}">
                    @else
                        <span class="blog-thumb-placeholder">
                            <span>
                                <i class="bi bi-journal-richtext" aria-hidden="true"></i>
                                BJDD Journal
                            </span>
                        </span>
                    @endif
                </a>

                <div class="blog-card-body">
                    <div class="blog-meta">
                        <span><i class="bi bi-calendar3" aria-hidden="true"></i>{{ optional($blog->created_at)->format('d M Y') ?: 'BJDD Blog' }}</span>
                        <span><i class="bi bi-bookmark" aria-hidden="true"></i>Academic Blog</span>
                    </div>

                    <h2 class="blog-card-title">
                        <a href="{{ route('blogs.show', $blog) }}">{{ $blog->display_title }}</a>
                    </h2>

                    @if($blog->excerpt)
                        <p class="blog-excerpt">{{ $blog->excerpt }}</p>
                    @endif

                    <a class="blog-read-link" href="{{ route('blogs.show', $blog) }}">
                        Read Article
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </a>
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
