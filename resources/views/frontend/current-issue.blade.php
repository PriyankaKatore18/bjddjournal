@extends('layouts.app')

@section('title', 'Current Issue | BJDD Journal')

@push('styles')
<style>
    .current-page {
        max-width: 1220px;
        margin: 0 auto;
        padding: 28px 18px 48px;
        color: #17221c;
    }

    .current-layout {
        display: grid;
        grid-template-columns: 220px minmax(0, 1fr);
        gap: 28px;
        align-items: start;
    }

    .current-sidebar,
    .current-overview,
    .current-article,
    .legacy-issue,
    .empty-state {
        background: #fff;
        border: 1px solid #dce5df;
        border-radius: 7px;
    }

    .current-sidebar {
        padding: 18px;
        position: sticky;
        top: 18px;
    }

    .current-sidebar h2 {
        color: #06452d;
        font-size: 1rem;
        margin: 0 0 12px;
        padding-bottom: 8px;
        border-bottom: 2px solid #c47d18;
    }

    .current-sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0 0 24px;
    }

    .current-sidebar li + li {
        margin-top: 7px;
    }

    .current-sidebar a {
        color: #183c2d;
        text-decoration: none;
        font-size: .9rem;
    }

    .current-sidebar a:hover {
        color: #c47d18;
    }

    .partner-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .partner-list img {
        width: 38px;
        height: 38px;
        object-fit: contain;
        border: 1px solid #dce5df;
        border-radius: 4px;
        padding: 4px;
    }

    .current-heading {
        margin-bottom: 17px;
    }

    .current-heading h1 {
        color: #06452d;
        font-size: 2.15rem;
        margin: 0 0 5px;
    }

    .current-heading p {
        color: #59665f;
        margin: 0;
    }

    .current-overview {
        display: grid;
        grid-template-columns: 128px minmax(0, 1fr);
        gap: 18px;
        padding: 18px;
        margin-bottom: 25px;
    }

    .current-cover {
        width: 128px;
        aspect-ratio: 1 / 1;
        object-fit: contain;
        padding: 6px;
        border: 1px solid #dce5df;
        border-radius: 4px;
        background: #fbfdfb;
    }

    .current-cover-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #66746c;
        font-size: .72rem;
        text-align: center;
    }

    .current-kicker,
    .article-type,
    .legacy-type {
        display: inline-block;
        color: #06452d;
        background: #eaf5ee;
        border: 1px solid #b7d8c2;
        border-radius: 3px;
        padding: 4px 7px;
        font-size: .67rem;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .article-access {
        display: inline-block;
        color: #8a4d00;
        background: #fff6df;
        border: 1px solid #e4c278;
        border-radius: 3px;
        padding: 4px 7px;
        font-size: .67rem;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-left: 5px;
    }

    .current-overview h2 {
        color: #06452d;
        font-size: 1.4rem;
        margin: 9px 0 5px;
    }

    .current-overview p {
        color: #59665f;
        margin: 0 0 11px;
    }

    .current-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 7px 15px;
        color: #59665f;
        font-size: .84rem;
    }

    .current-meta strong {
        color: #17221c;
    }

    .listing-heading {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 15px;
        border-bottom: 1px solid #a9c5b5;
        padding-bottom: 8px;
        margin-bottom: 13px;
    }

    .listing-heading h2 {
        color: #06452d;
        font-size: 1.3rem;
        margin: 0;
    }

    .listing-heading span {
        color: #59665f;
        font-size: .85rem;
    }

    .listing-controls {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        justify-content: end;
        gap: 8px;
    }

    .listing-controls select {
        border: 1px solid #cbd8d0;
        border-radius: 4px;
        padding: 6px 8px;
        color: #17221c;
        background: #fff;
        font-size: .8rem;
    }

    .current-article {
        display: grid;
        grid-template-columns: 48px minmax(0, 1fr) 132px;
        gap: 14px;
        padding: 16px;
        margin-bottom: 11px;
    }

    .article-number {
        color: #0b6b42;
        font-size: 1.45rem;
        font-weight: 800;
        line-height: 1;
    }

    .current-article h3 {
        color: #06452d;
        font-size: 1.04rem;
        line-height: 1.35;
        margin: 8px 0 5px;
        overflow-wrap: anywhere;
    }

    .article-authors {
        color: #34443a;
        font-size: .88rem;
        margin: 0 0 8px;
    }

    .article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 5px 12px;
        color: #59665f;
        font-size: .76rem;
        margin-bottom: 8px;
    }

    .article-meta strong {
        color: #34443a;
    }

    .article-abstract {
        color: #59665f;
        font-size: .82rem;
        line-height: 1.5;
        margin: 0;
    }

    .article-actions {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 7px;
    }

    .article-actions a {
        display: block;
        color: #06452d;
        background: #fff;
        border: 1px solid #9bb3a4;
        border-radius: 4px;
        padding: 7px 8px;
        text-align: center;
        font-size: .77rem;
        font-weight: 700;
        text-decoration: none;
    }

    .article-actions a:first-child {
        color: #fff;
        background: #06452d;
        border-color: #06452d;
    }

    .article-actions a:hover {
        border-color: #c47d18;
    }

    .legacy-group h2 {
        color: #06452d;
        font-size: 1.3rem;
        border-bottom: 1px solid #a9c5b5;
        padding-bottom: 8px;
        margin: 0 0 13px;
    }

    .legacy-issue {
        padding: 17px;
        margin-bottom: 12px;
    }

    .legacy-issue h3 {
        color: #06452d;
        font-size: 1.05rem;
        margin: 9px 0;
        overflow-wrap: anywhere;
    }

    .legacy-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 6px 15px;
        color: #59665f;
        font-size: .8rem;
        margin-bottom: 9px;
    }

    .legacy-abstract {
        color: #59665f;
        font-size: .84rem;
        line-height: 1.55;
        margin: 0 0 12px;
    }

    .legacy-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
    }

    .legacy-actions a {
        color: #06452d;
        border: 1px solid #9bb3a4;
        border-radius: 4px;
        padding: 7px 10px;
        font-size: .78rem;
        font-weight: 700;
        text-decoration: none;
    }

    .empty-state {
        color: #59665f;
        padding: 30px 15px;
        text-align: center;
    }

    @media (max-width: 900px) {
        .current-layout {
            grid-template-columns: 1fr;
        }

        .current-sidebar {
            position: static;
        }
    }

    @media (max-width: 680px) {
        .current-page {
            padding: 20px 12px 34px;
        }

        .current-overview,
        .current-article {
            grid-template-columns: 1fr;
        }

        .current-cover {
            width: 100px;
        }

        .current-heading h1 {
            font-size: 1.7rem;
        }

        .article-actions {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 420px) {
        .article-actions {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
@php
    use App\Support\ArticleHelper;
    $hasPublicationListing = $publications->isNotEmpty();
    $firstPublication = $publications->first();
    $issueVolume = $currentIssue?->volume ?: $firstPublication?->volume;
    $issueNumber = $currentIssue?->issue ?: $firstPublication?->issue;
    $issueDate = $currentIssue?->month_year ?: $firstPublication?->issue_range ?: $firstPublication?->year;
    $issueIssn = $currentIssue?->e_issn ?: $firstPublication?->eissn;
    $issueRecord = $issues->first();
@endphp

<main class="current-page">
    <div class="current-layout">
        <aside class="current-sidebar" aria-label="Current issue navigation">
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
            <div class="current-heading">
                <h1>Current Issue</h1>
                <p>Published research from {{ ArticleHelper::JOURNAL_NAME }}.</p>
            </div>

            @if($issueVolume && $issueNumber)
                <section class="current-overview" aria-labelledby="current-issue-title">
                    @if($issueRecord?->cover_image)
                        <img class="current-cover" src="{{ ArticleHelper::issueCoverUrl($issueRecord->cover_image) }}" alt="Volume {{ $issueVolume }} Issue {{ $issueNumber }} cover">
                    @else
                        <div class="current-cover current-cover-placeholder" role="img" aria-label="No cover uploaded">No cover uploaded</div>
                    @endif
                    <div>
                        <span class="current-kicker">Volume {{ $issueVolume }} - Issue {{ $issueNumber }}</span>
                        <h2 id="current-issue-title">{{ $issueDate ?: 'Current published issue' }}</h2>
                        <p>{{ ArticleHelper::JOURNAL_NAME }}</p>
                        <div class="current-meta">
                            @if($issueDate)<span><strong>Published:</strong> {{ $issueDate }}</span>@endif
                            @if($issueIssn)<span><strong>ISSN:</strong> {{ $issueIssn }}</span>@endif
                            <span><strong>Total Articles:</strong> {{ $hasPublicationListing ? $publications->count() : $issues->count() }}</span>
                        </div>
                    </div>
                </section>
            @endif

            @if($hasPublicationListing)
                <div class="listing-heading">
                    <h2>Articles in this Issue</h2>
                    <div class="listing-controls">
                        <span>{{ $publications->count() }} article{{ $publications->count() === 1 ? '' : 's' }}</span>
                        <label class="visually-hidden" for="current-sort">Sort articles</label>
                        <select id="current-sort">
                            <option value="order">Article order</option>
                            <option value="title">Title A-Z</option>
                            <option value="year">Publication year</option>
                        </select>
                    </div>
                </div>

                @foreach($publications as $publication)
                    @php
                        $doiUrl = ArticleHelper::doiUrl($publication->crossref_doi);
                        $pdfExists = $publication->paper_pdf && Storage::disk('public')->exists($publication->paper_pdf);
                    @endphp
                    <article class="current-article" data-article-title="{{ strtolower($publication->paper_title) }}" data-article-year="{{ $publication->year ?: 0 }}" data-article-number="{{ $loop->iteration }}">
                        <div class="article-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                        <div>
                            <span class="article-type">Research Article</span>
                            <span class="article-access">Open Access</span>
                            <h3>{{ $publication->paper_title }}</h3>
                            <p class="article-authors">{{ implode(', ', ArticleHelper::authors($publication->author_name)) }}</p>
                            <div class="article-meta">
                                @if($publication->year)<span><strong>Published:</strong> {{ $publication->year }}</span>@endif
                                @if($publication->volume)<span><strong>Vol:</strong> {{ $publication->volume }}</span>@endif
                                @if($publication->issue)<span><strong>Issue:</strong> {{ $publication->issue }}</span>@endif
                                @if($publication->page_nos)<span><strong>Pages:</strong> {{ $publication->page_nos }}</span>@endif
                                @if($publication->published_paper_id)<span><strong>Paper ID:</strong> {{ $publication->published_paper_id }}</span>@endif
                                @if($publication->registration_id)<span><strong>Registration ID:</strong> {{ $publication->registration_id }}</span>@endif
                                @if($doiUrl)<span><strong>DOI:</strong> <a href="{{ $doiUrl }}" target="_blank" rel="noopener">{{ ArticleHelper::normalizeDoi($publication->crossref_doi) }}</a></span>@endif
                            </div>
                            @if($publication->abstract)
                                <p class="article-abstract">{{ \Illuminate\Support\Str::limit($publication->abstract, 270) }}</p>
                            @endif
                            @if($publication->keywords)
                                <p class="article-meta"><strong>Keywords:</strong> {{ $publication->keywords }}</p>
                            @endif
                        </div>
                        <div class="article-actions">
                            <a href="{{ route('article.details', ['publicationKey' => ArticleHelper::routeKey($publication)]) }}">View Article</a>
                            @if($pdfExists)
                                <a href="{{ route('publications.viewPdf', $publication->id) }}" target="_blank" rel="noopener">Download PDF</a>
                            @endif
                            @if($doiUrl)
                                <a href="{{ $doiUrl }}" target="_blank" rel="noopener">View DOI</a>
                            @endif
                        </div>
                    </article>
                @endforeach
            @elseif($issues->isNotEmpty())
                @php
                    $groupedIssues = $issues->groupBy(fn ($issue) => 'Volume ' . $issue->volume . ', Issue ' . $issue->number);
                @endphp

                @foreach($groupedIssues as $volumeIssue => $issuesInGroup)
                    <div class="legacy-group">
                        <h2>{{ $volumeIssue }}</h2>
                        @foreach($issuesInGroup as $issue)
                            @php
                                $legacyDoi = ArticleHelper::doiUrl($issue->crossref_doi_member_id);
                                $certificatePath = $issue->paper_certificate ? (str_starts_with($issue->paper_certificate, 'certificates/') ? $issue->paper_certificate : 'certificates/' . $issue->paper_certificate) : null;
                                $certificateExists = $certificatePath && Storage::disk('public')->exists($certificatePath);
                                $pdfExists = $issue->published_paper_pdf && Storage::disk('public')->exists($issue->published_paper_pdf);
                            @endphp
                            <article class="legacy-issue">
                                <span class="legacy-type">Research Article</span>
                                <h3>{{ $issue->title }}</h3>
                                <div class="legacy-meta">
                                    @if($issue->year)<span>Year: {{ $issue->year }}</span>@endif
                                    @if($issue->page_no)<span>Pages: {{ $issue->page_no }}</span>@endif
                                    @if($issue->registration_id)<span>Registration ID: {{ $issue->registration_id }}</span>@endif
                                    @if($issue->published_paper_id)<span>Paper ID: {{ $issue->published_paper_id }}</span>@endif
                                    @if($legacyDoi)<span>DOI: <a href="{{ $legacyDoi }}" target="_blank" rel="noopener">{{ ArticleHelper::normalizeDoi($issue->crossref_doi_member_id) }}</a></span>@endif
                                </div>
                                @if($issue->abstract)
                                    <p class="legacy-abstract">{{ $issue->abstract }}</p>
                                @endif
                                <div class="legacy-actions">
                                    @if($pdfExists)
                                        <a href="{{ route('issues.download', $issue->id) }}" target="_blank" rel="noopener">Download PDF</a>
                                    @endif
                                    @if($certificateExists)
                                        <a href="{{ asset('storage/' . $certificatePath) }}" target="_blank" rel="noopener">View Certificate</a>
                                    @endif
                                    @if($legacyDoi)
                                        <a href="{{ $legacyDoi }}" target="_blank" rel="noopener">View DOI</a>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endforeach
            @else
                <div class="empty-state">No current issue is available.</div>
            @endif
        </section>
    </div>
</main>

@if($hasPublicationListing)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sortSelect = document.getElementById('current-sort');
        const listing = sortSelect ? sortSelect.closest('section').querySelectorAll('.current-article') : [];

        if (!sortSelect || !listing.length) {
            return;
        }

        sortSelect.addEventListener('change', function () {
            const articles = Array.from(listing);
            const container = articles[0].parentElement;

            articles.sort(function (first, second) {
                if (sortSelect.value === 'title') {
                    return first.dataset.articleTitle.localeCompare(second.dataset.articleTitle);
                }

                if (sortSelect.value === 'year') {
                    return Number(second.dataset.articleYear) - Number(first.dataset.articleYear);
                }

                return Number(first.dataset.articleNumber) - Number(second.dataset.articleNumber);
            });

            articles.forEach(function (article) {
                container.appendChild(article);
            });
        });
    });
</script>
@endif
@endsection
