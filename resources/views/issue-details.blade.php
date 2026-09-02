@extends('layouts.app')

@section('title', 'Volume ' . $volume . ', Issue ' . $issue . ' | BJDD Journal')

@push('styles')
<style>
    .issue-page {
        max-width: 1220px;
        margin: 0 auto;
        padding: 28px 18px 48px;
        color: #17221c;
    }

    .issue-back {
        color: #06452d;
        text-decoration: none;
        font-weight: 700;
        display: inline-block;
        margin-bottom: 16px;
    }

    .issue-overview,
    .article-row {
        background: #fff;
        border: 1px solid #dce5df;
        border-radius: 7px;
    }

    .issue-overview {
        display: grid;
        grid-template-columns: 150px minmax(0, 1fr);
        gap: 22px;
        padding: 20px;
        margin-bottom: 28px;
    }

    .issue-cover {
        width: 150px;
        aspect-ratio: 1 / 1;
        object-fit: contain;
        border: 1px solid #dce5df;
        border-radius: 4px;
        padding: 8px;
        background: #fbfdfb;
    }

    .issue-kicker {
        display: inline-block;
        color: #06452d;
        background: #eaf5ee;
        border: 1px solid #b7d8c2;
        border-radius: 3px;
        padding: 4px 8px;
        font-size: .7rem;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .issue-overview h1 {
        color: #06452d;
        font-size: 2.2rem;
        margin: 10px 0 6px;
    }

    .issue-overview p {
        color: #59665f;
        margin: 0 0 16px;
    }

    .issue-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 18px;
        color: #59665f;
        font-size: .86rem;
    }

    .issue-stats strong {
        color: #17221c;
    }

    .article-heading {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 16px;
        border-bottom: 1px solid #a9c5b5;
        margin-bottom: 14px;
        padding-bottom: 8px;
    }

    .article-heading h2 {
        color: #06452d;
        font-size: 1.35rem;
        margin: 0;
    }

    .article-heading span {
        color: #59665f;
        font-size: .85rem;
    }

    .article-row {
        display: grid;
        grid-template-columns: 50px minmax(0, 1fr) 142px;
        gap: 15px;
        padding: 17px;
        margin-bottom: 12px;
    }

    .article-number {
        color: #0b6b42;
        font-size: 1.55rem;
        font-weight: 800;
        line-height: 1;
    }

    .article-type {
        display: inline-block;
        color: #0b6b42;
        border: 1px solid #a9cdb7;
        border-radius: 3px;
        padding: 3px 6px;
        font-size: .65rem;
        font-weight: 800;
        letter-spacing: .03em;
        text-transform: uppercase;
    }

    .article-access {
        display: inline-block;
        color: #8a4d00;
        background: #fff6df;
        border: 1px solid #e4c278;
        border-radius: 3px;
        padding: 3px 6px;
        font-size: .65rem;
        font-weight: 800;
        letter-spacing: .03em;
        text-transform: uppercase;
        margin-left: 5px;
    }

    .article-row h3 {
        margin: 8px 0 6px;
        color: #06452d;
        font-size: 1.06rem;
        line-height: 1.35;
        overflow-wrap: anywhere;
    }

    .article-authors {
        color: #34443a;
        font-size: .9rem;
        margin: 0 0 9px;
    }

    .article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 5px 13px;
        color: #59665f;
        font-size: .77rem;
        margin-bottom: 9px;
    }

    .article-meta strong {
        color: #34443a;
    }

    .article-abstract {
        color: #59665f;
        font-size: .84rem;
        line-height: 1.55;
        margin: 0 0 8px;
    }

    .article-keywords {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        color: #59665f;
        font-size: .76rem;
    }

    .article-keyword {
        background: #f1f6f2;
        border: 1px solid #d7e4da;
        border-radius: 3px;
        padding: 3px 6px;
    }

    .article-actions {
        display: flex;
        flex-direction: column;
        gap: 7px;
        align-self: center;
    }

    .article-actions a {
        display: block;
        text-align: center;
        border: 1px solid #9bb3a4;
        border-radius: 4px;
        color: #06452d;
        background: #fff;
        padding: 7px 8px;
        font-size: .78rem;
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

    .empty-state {
        color: #59665f;
        text-align: center;
        padding: 28px;
        border: 1px solid #dce5df;
        border-radius: 7px;
        background: #fff;
    }

    @media (max-width: 700px) {
        .issue-overview,
        .article-row {
            grid-template-columns: 1fr;
        }

        .issue-cover {
            width: 110px;
        }

        .issue-overview h1 {
            font-size: 1.7rem;
        }

        .article-number {
            font-size: 1.25rem;
        }

        .article-actions {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 430px) {
        .issue-page {
            padding: 20px 12px 34px;
        }

        .article-actions {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
@php
    use App\Support\ArticleHelper;
    $firstPaper = $papers->first();
    $totalArticles = $papers->total();
    $publishedDate = $issueMeta?->publish_date;
    $issueRange = $firstPaper?->issue_range;
    $issueIssn = $firstPaper?->eissn ?: $issueMeta?->approved_eissn;
    $coverUrl = ArticleHelper::journalCoverUrl();
@endphp

<main class="issue-page">
    <a class="issue-back" href="{{ route('archive') }}">Back to Archive</a>

    <section class="issue-overview" aria-labelledby="issue-title">
        <img class="issue-cover" src="{{ $coverUrl }}" alt="BJDD journal cover">
        <div>
            <span class="issue-kicker">Volume {{ $volume }} - Issue {{ $issue }}</span>
            <h1 id="issue-title">{{ $issueRange ?: 'Published Issue' }}</h1>
            <p>{{ ArticleHelper::JOURNAL_NAME }}</p>
            <div class="issue-stats">
                @if($publishedDate)
                    <span><strong>Published:</strong> {{ \Carbon\Carbon::parse($publishedDate)->format('d F Y') }}</span>
                @elseif($firstPaper?->year)
                    <span><strong>Published:</strong> {{ $firstPaper->year }}</span>
                @endif
                <span><strong>Total Articles:</strong> {{ $totalArticles }}</span>
                @if($issueIssn)
                    <span><strong>ISSN:</strong> {{ $issueIssn }}</span>
                @endif
            </div>
        </div>
    </section>

    <div class="article-heading">
        <h2>Articles in this Issue</h2>
        <span>{{ $totalArticles }} article{{ $totalArticles === 1 ? '' : 's' }}</span>
    </div>

    @forelse($papers as $paper)
        @php
            $articleNumber = (($papers->currentPage() - 1) * $papers->perPage()) + $loop->iteration;
            $doiUrl = ArticleHelper::doiUrl($paper->crossref_doi);
            $keywords = preg_split('/[,;]+/', (string) $paper->keywords, -1, PREG_SPLIT_NO_EMPTY);
            $pdfExists = $paper->paper_pdf && Storage::disk('public')->exists($paper->paper_pdf);
        @endphp
        <article class="article-row">
            <div class="article-number">{{ str_pad($articleNumber, 2, '0', STR_PAD_LEFT) }}</div>

            <div>
                <span class="article-type">Research Article</span>
                <span class="article-access">Open Access</span>
                <h3>{{ $paper->paper_title }}</h3>
                <p class="article-authors">{{ implode(', ', ArticleHelper::authors($paper->author_name)) }}</p>

                <div class="article-meta">
                    @if($paper->year)<span><strong>Published:</strong> {{ $paper->year }}</span>@endif
                    @if($paper->volume)<span><strong>Vol:</strong> {{ $paper->volume }}</span>@endif
                    @if($paper->issue)<span><strong>Issue:</strong> {{ $paper->issue }}</span>@endif
                    @if($paper->page_nos)<span><strong>Pages:</strong> {{ $paper->page_nos }}</span>@endif
                    @if($paper->published_paper_id)<span><strong>Paper ID:</strong> {{ $paper->published_paper_id }}</span>@endif
                    @if($paper->registration_id)<span><strong>Registration ID:</strong> {{ $paper->registration_id }}</span>@endif
                    @if($paper->eissn)<span><strong>eISSN:</strong> {{ $paper->eissn }}</span>@endif
                    @if($doiUrl)<span><strong>DOI:</strong> <a href="{{ $doiUrl }}" target="_blank" rel="noopener">{{ ArticleHelper::normalizeDoi($paper->crossref_doi) }}</a></span>@endif
                </div>

                @if($paper->abstract)
                    <p class="article-abstract">{{ \Illuminate\Support\Str::limit($paper->abstract, 270) }}</p>
                @endif

                @if(count($keywords))
                    <div class="article-keywords">
                        @foreach($keywords as $keyword)
                            <span class="article-keyword">{{ trim($keyword) }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="article-actions">
                <a href="{{ route('article.details', ['publicationKey' => ArticleHelper::routeKey($paper)]) }}">View Article</a>
                @if($pdfExists)
                    <a href="{{ route('publications.viewPdf', $paper->id) }}" target="_blank" rel="noopener">Download PDF</a>
                @endif
                @if($doiUrl)
                    <a href="{{ $doiUrl }}" target="_blank" rel="noopener">View DOI</a>
                @endif
            </div>
        </article>
    @empty
        <div class="empty-state">No articles are available for this issue.</div>
    @endforelse

    @if($papers->hasPages())
        <div class="mt-4">{{ $papers->links() }}</div>
    @endif
</main>
@endsection
