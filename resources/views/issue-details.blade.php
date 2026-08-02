@extends('layouts.app')

@section('content')

<style>
    .issue-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 0 15px;
    }

    .issue-header {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
    }

    .issue-title {
        font-size: 32px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 10px;
    }

    .article-count {
        color: #6b7280;
        font-size: 15px;
    }

    .paper-card {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
        transition: .3s;
    }

    .paper-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .10);
    }

    .paper-badge {
        display: inline-block;
        background: #e8f7ec;
        color: #198754;
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .paper-title {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 10px;
    }

    .paper-author {
        color: #4b5563;
        margin-bottom: 15px;
        font-size: 15px;
    }

    .paper-abstract {
        color: #374151;
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .paper-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
        color: #6b7280;
        font-size: 14px;
    }

    .paper-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .btn-paper {
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: .3s;
    }

    .btn-view {
        background: #dc2626;
        color: white;
    }

    .btn-view:hover {
        background: #b91c1c;
        color: white;
    }

    .btn-certificate {
        background: #198754;
        color: white;
    }

    .btn-certificate:hover {
        background: #146c43;
        color: white;
    }

    .back-btn {
        display: inline-block;
        margin-bottom: 20px;
        text-decoration: none;
        color: #dc2626;
        font-weight: 600;
    }

    @media(max-width:768px) {

        .paper-title {
            font-size: 22px;
        }

        .issue-title {
            font-size: 24px;
        }

        .paper-card {
            padding: 18px;
        }
    }
</style>

<div class="issue-container">

    <a href="{{ route('archive') }}" class="back-btn">
        ← Back to Archive
    </a>

    <div class="issue-header">
        <h1 class="issue-title">
            Volume {{ $volume }}, Issue {{ $issue }}
        </h1>

        <div class="article-count">
            Showing {{ $papers->count() }} Articles
        </div>
    </div>

    @forelse($papers as $paper)

    <div class="paper-card">

        <span class="paper-badge">
            Research Paper
        </span>

        <h2 class="paper-title">
            {{ $paper->paper_title }}
        </h2>

        <div class="paper-author">
            {{ $paper->author_name }}
        </div>

        @if($paper->abstract)
        <div class="paper-abstract">
            {{ Str::limit($paper->abstract, 500) }}
        </div>
        @endif

        <div class="paper-meta">
            <span>
                <strong>Registration ID:</strong>
                {{ $paper->registration_id ?? 'N/A' }}
            </span>

            <span>
                <strong>Paper ID:</strong>
                {{ $paper->published_paper_id ?? 'N/A' }}
            </span>

            <span>
                <strong>Year:</strong>
                {{ $paper->year }}
            </span>

            @if($paper->crossref_doi)
            <span>
                <strong>DOI:</strong>
                <a href="{{ $paper->crossref_doi }}"
                    target="_blank">
                    View DOI
                </a>
            </span>
            @endif
        </div>

        <div class="paper-actions">

            <a href="{{ route('article.details', $paper->id) }}"
                class="btn-paper btn-view">
                Read More
            </a>

            @if($paper->certificate_path)
            <a href="{{ asset('storage/' . $paper->certificate_path) }}"
                target="_blank"
                class="btn-paper btn-certificate">
                Certificate
            </a>
            @endif

        </div>

    </div>

    @empty

    <div class="paper-card">
        <h4>No Articles Found</h4>
    </div>

    @endforelse
    <div class="mt-4 d-flex justify-content-center">
        {{ $papers->links() }}
    </div>

</div>

@endsection