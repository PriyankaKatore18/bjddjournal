@extends('layouts.app')

@section('title', 'Archive | BJDD Journal')

@push('styles')
<style>
    .archive-page {
        max-width: 1220px;
        margin: 0 auto;
        padding: 28px 18px 48px;
        color: #17221c;
    }

    .archive-layout {
        display: grid;
        grid-template-columns: 220px minmax(0, 1fr);
        gap: 28px;
        align-items: start;
    }

    .archive-sidebar,
    .archive-panel,
    .issue-card {
        background: #fff;
        border: 1px solid #dce5df;
        border-radius: 7px;
    }

    .archive-sidebar {
        padding: 18px;
        position: sticky;
        top: 18px;
    }

    .archive-sidebar h2 {
        color: #06452d;
        font-size: 1rem;
        margin: 0 0 12px;
        padding-bottom: 8px;
        border-bottom: 2px solid #c47d18;
    }

    .archive-sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0 0 24px;
    }

    .archive-sidebar li + li {
        margin-top: 7px;
    }

    .archive-sidebar a {
        color: #183c2d;
        text-decoration: none;
        font-size: .9rem;
    }

    .archive-sidebar a:hover {
        color: #c47d18;
    }

    .archive-sidebar .partner-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
    }

    .archive-sidebar .partner-list a {
        min-width: 0;
    }

    .archive-sidebar .partner-list img {
        width: 100%;
        height: 38px;
        object-fit: contain;
        box-sizing: border-box;
        border: 1px solid #dce5df;
        border-radius: 4px;
        padding: 4px;
    }

    .archive-heading {
        display: flex;
        justify-content: space-between;
        gap: 18px;
        align-items: end;
        margin-bottom: 18px;
    }

    .archive-heading h1 {
        color: #06452d;
        font-size: 2.15rem;
        margin: 0 0 5px;
    }

    .archive-heading p {
        color: #59665f;
        margin: 0;
    }

    .archive-panel {
        padding: 16px;
        margin-bottom: 20px;
    }

    .archive-filter {
        display: grid;
        grid-template-columns: minmax(180px, 1fr) 140px 140px auto auto;
        gap: 9px;
        align-items: end;
    }

    .archive-filter label {
        display: block;
        color: #496055;
        font-size: .76rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .archive-filter input,
    .archive-filter select {
        min-width: 0;
        width: 100%;
        min-height: 38px;
        border: 1px solid #cbd8d0;
        border-radius: 4px;
        padding: 7px 9px;
        color: #17221c;
        background: #fff;
    }

    .archive-button {
        min-height: 38px;
        border-radius: 4px;
        border: 1px solid #06452d;
        padding: 7px 14px;
        text-decoration: none;
        font-weight: 700;
        white-space: nowrap;
    }

    .archive-button-primary {
        color: #fff;
        background: #06452d;
    }

    .archive-button-secondary {
        color: #06452d;
        background: #fff;
    }

    .archive-summary {
        color: #59665f;
        font-size: .9rem;
        margin: 0 0 20px;
    }

    .archive-year {
        margin: 0 0 24px;
    }

    .archive-year summary {
        cursor: pointer;
        list-style-position: inside;
        color: #06452d;
        font-size: 1.25rem;
        font-weight: 800;
        padding: 7px 0;
        border-bottom: 1px solid #a9c5b5;
    }

    .archive-year summary::marker {
        color: #c47d18;
    }

    .year-count {
        color: #66746c;
        font-size: .84rem;
        font-weight: 600;
    }

    .issue-card {
        display: grid;
        grid-template-columns: 116px minmax(0, 1fr) auto;
        gap: 18px;
        align-items: center;
        padding: 16px;
        margin-top: 12px;
    }

    .issue-cover {
        width: 116px;
        aspect-ratio: 1 / 1;
        object-fit: contain;
        border: 1px solid #dce5df;
        border-radius: 4px;
        background: #fbfdfb;
        padding: 6px;
    }

    .issue-cover-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #66746c;
        font-size: .72rem;
        text-align: center;
    }

    .issue-card h3 {
        margin: 0 0 7px;
        color: #06452d;
        font-size: 1.08rem;
    }

    .issue-labels {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-bottom: 8px;
    }

    .issue-label {
        display: inline-block;
        color: #06452d;
        background: #eaf5ee;
        border: 1px solid #b7d8c2;
        border-radius: 3px;
        padding: 3px 7px;
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .issue-label-current {
        color: #8a4d00;
        background: #fff6df;
        border-color: #e4c278;
    }

    .issue-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 7px 16px;
        color: #59665f;
        font-size: .84rem;
    }

    .issue-articles {
        margin: 10px 0 0;
        padding-left: 17px;
        color: #59665f;
        font-size: .83rem;
    }

    .issue-description {
        color: #59665f;
        font-size: .86rem;
        line-height: 1.5;
        margin: 8px 0 0;
    }

    .issue-articles li {
        margin-top: 4px;
        overflow-wrap: anywhere;
    }

    .issue-action {
        color: #fff;
        background: #06452d;
        border: 1px solid #06452d;
        border-radius: 4px;
        display: inline-block;
        padding: 9px 13px;
        text-decoration: none;
        font-weight: 700;
        white-space: nowrap;
    }

    .empty-state {
        text-align: center;
        color: #59665f;
        padding: 30px 12px;
    }

    @media (max-width: 900px) {
        .archive-layout {
            grid-template-columns: 1fr;
        }

        .archive-sidebar {
            position: static;
        }

        .archive-filter {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .archive-page {
            padding: 20px 12px 34px;
        }

        .archive-heading {
            display: block;
        }

        .archive-heading h1 {
            font-size: 1.7rem;
        }

        .archive-filter,
        .issue-card {
            grid-template-columns: 1fr;
        }

        .issue-cover {
            width: 92px;
        }

        .issue-action {
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
@php
    $archiveTitle = $archiveSettings['archive_title'] ?? 'Publication Archive';
    $archiveDescription = $archiveSettings['archive_description'] ?? 'Browse published articles by year, volume, and issue.';
    $totalArticles = $archiveIssues->flatten(1)->sum(fn ($archiveIssue) => $archiveIssue->article_count);
    $totalIssues = $archiveIssues->flatten(1)->count();
@endphp

<main class="archive-page">
    <div class="archive-layout">
        <aside class="archive-sidebar" aria-label="Archive navigation">
            <h2>Journal Navigation</h2>
            <ul>
                <li><a href="{{ route('current-issue') }}">Current Issue</a></li>
                <li><a href="{{ route('archive') }}">Publication Archive</a></li>
                <li><a href="{{ route('call-for-papers') }}">Call for Papers</a></li>
                <li><a href="{{ route('submit.paper') }}">Submit a Paper</a></li>
            </ul>

            <h2>Indexing Partners</h2>
            <div class="partner-list">
                @forelse($partners as $partner)
                    <a href="{{ $partner->url }}" target="_blank" rel="noopener" aria-label="{{ $partner->name ?? 'Indexing partner' }}">
                        <img src="{{ asset('storage/app/public/' . $partner->icon) }}" alt="{{ $partner->name ?? 'Indexing partner' }}">
                    </a>
                @empty
                    <span class="text-muted small">No partners listed.</span>
                @endforelse
            </div>

            <h2 class="mt-4">Downloads</h2>
            <ul>
                <li><a href="https://docs.google.com/document/d/1Z8bpXSTGNcpDuV3F1wpgzWM5pLVHY1X0/edit?usp=sharing" target="_blank" rel="noopener">Research Paper Format</a></li>
                <li><a href="{{ route('policy') }}">Copyright and undertaking policy</a></li>
            </ul>
        </aside>

        <section>
            <div class="archive-heading">
                <div>
                    <h1>{{ $archiveTitle }}</h1>
                    <p>{{ $archiveDescription }}</p>
                </div>
            </div>

            <div class="archive-panel">
                <form class="archive-filter" method="get" action="{{ route('archive') }}">
                    <div>
                        <label for="archive-search">Search articles</label>
                        <input id="archive-search" type="search" name="search" value="{{ $filters['search'] }}" placeholder="Title, author, paper ID, DOI">
                    </div>
                    <div>
                        <label for="archive-year">Year</label>
                        <select id="archive-year" name="year">
                            <option value="">All years</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" @selected((string) $filters['year'] === (string) $year)>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="archive-volume">Volume</label>
                        <select id="archive-volume" name="volume">
                            <option value="">All volumes</option>
                            @foreach($volumes as $volumeOption)
                                <option value="{{ $volumeOption }}" @selected((string) $filters['volume'] === (string) $volumeOption)>Volume {{ $volumeOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="archive-button archive-button-primary" type="submit">Search</button>
                    <a class="archive-button archive-button-secondary" href="{{ route('archive') }}">Clear</a>
                </form>
            </div>

            <p class="archive-summary">{{ $totalArticles }} article{{ $totalArticles === 1 ? '' : 's' }} found across {{ $totalIssues }} issue{{ $totalIssues === 1 ? '' : 's' }}.</p>

            @forelse($archiveIssues as $year => $issuesInYear)
                <details class="archive-year" @if($loop->first) open @endif>
                    <summary>{{ $year }} <span class="year-count">({{ $issuesInYear->sum('article_count') }} articles)</span></summary>

                    @foreach($issuesInYear as $archiveIssue)
                        <article class="issue-card">
                            @if($archiveIssue->cover_image)
                                <img class="issue-cover" src="{{ \App\Support\ArticleHelper::issueCoverUrl($archiveIssue->cover_image) }}" alt="Volume {{ $archiveIssue->volume }} Issue {{ $archiveIssue->issue }} cover">
                            @else
                                <div class="issue-cover issue-cover-placeholder" role="img" aria-label="No cover uploaded">No cover uploaded</div>
                            @endif

                            <div>
                                <div class="issue-labels">
                                    <span class="issue-label">Volume {{ $archiveIssue->volume }} - Issue {{ $archiveIssue->issue }}</span>
                                    @if($archiveIssue->is_current)
                                        <span class="issue-label issue-label-current">Current issue</span>
                                    @endif
                                </div>
                                <h3>{{ $archiveIssue->title ?: $archiveIssue->issue_range ?: 'Issue ' . $archiveIssue->issue }}</h3>
                                <div class="issue-meta">
                                    <span>{{ $archiveIssue->article_count }} article{{ $archiveIssue->article_count === 1 ? '' : 's' }}</span>
                                    @if($archiveIssue->published_at)
                                        <span>Published {{ \Carbon\Carbon::parse($archiveIssue->published_at)->format('d F Y') }}</span>
                                    @else
                                        <span>Published {{ $archiveIssue->year }}</span>
                                    @endif
                                </div>
                                @if($archiveIssue->description)
                                    <p class="issue-description">{{ $archiveIssue->description }}</p>
                                @endif
                                <ol class="issue-articles">
                                    @foreach($archiveIssue->papers->take(3) as $paper)
                                        <li>{{ $paper->paper_title }}</li>
                                    @endforeach
                                    @if($archiveIssue->article_count > 3)
                                        <li>And {{ $archiveIssue->article_count - 3 }} more article{{ $archiveIssue->article_count - 3 === 1 ? '' : 's' }}.</li>
                                    @endif
                                </ol>
                            </div>

                            <a class="issue-action" href="{{ route('archive.issue', ['volume' => $archiveIssue->volume, 'issue' => $archiveIssue->issue]) }}">View issue</a>
                        </article>
                    @endforeach
                </details>
            @empty
                <div class="archive-panel empty-state">
                    No publications match the selected filters.
                </div>
            @endforelse
        </section>
    </div>
</main>
@endsection
