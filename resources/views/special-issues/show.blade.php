@extends('layouts.app')

@section('title', $specialIssue->title . ' | BJDD Journal')

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
    .article-row,
    .special-editorial {
        background: #fff;
        border: 1px solid #dce5df;
        border-radius: 7px;
    }

    .issue-overview {
        overflow: hidden;
        margin-bottom: 28px;
    }

    .special-banner {
        display: block;
        width: 100%;
        height: 320px;
        object-fit: cover;
        border-bottom: 1px solid #dce5df;
        background: #fbfdfb;
    }

    .special-banner-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #66746c;
        font-size: .9rem;
        text-align: center;
    }

    .special-overview-body {
        padding: 20px;
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

    .issue-downloads {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 18px;
    }

    .issue-downloads a {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #0b6b42;
        border-radius: 4px;
        color: #fff;
        background: #0b6b42;
        font-size: .8rem;
        font-weight: 700;
        text-decoration: none;
    }

    .issue-downloads a:hover {
        background: #06452d;
        border-color: #06452d;
    }

    .issue-downloads a.disabled {
        color: #6b7770;
        background: #f1f4f2;
        border-color: #cbd7cf;
        cursor: not-allowed;
        pointer-events: none;
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

    .special-editorial {
        padding: 20px;
        margin-bottom: 28px;
    }

    .editorial-note {
        white-space: pre-line;
        color: #59665f;
        line-height: 1.6;
        margin: 0 0 18px;
    }

    .editor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 14px;
    }

    .editor-card {
        display: grid;
        grid-template-columns: 64px minmax(0, 1fr);
        gap: 12px;
        align-items: center;
        border: 1px solid #dce5df;
        border-radius: 6px;
        padding: 12px;
        background: #fbfdfb;
    }

    .editor-photo {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #dce5df;
        background: #eaf5ee;
    }

    .editor-photo-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #06452d;
        font-weight: 800;
    }

    .editor-card h3 {
        color: #06452d;
        font-size: 1rem;
        margin: 0 0 3px;
    }

    .editor-card p {
        color: #59665f;
        font-size: .8rem;
        margin: 0;
        line-height: 1.45;
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

    .article-type,
    .article-access {
        display: inline-block;
        border-radius: 3px;
        padding: 3px 6px;
        font-size: .65rem;
        font-weight: 800;
        letter-spacing: .03em;
        text-transform: uppercase;
    }

    .article-type {
        color: #0b6b42;
        border: 1px solid #a9cdb7;
    }

    .article-access {
        color: #8a4d00;
        background: #fff6df;
        border: 1px solid #e4c278;
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

    .article-meta a {
        color: #06452d;
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
        .special-banner {
            height: 210px;
        }

        .article-row {
            grid-template-columns: 1fr;
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
    $totalArticles = $articles->total();
    $firstArticle = $articles->first();
    $issueIssn = $firstArticle?->eissn;
    $publishedDate = $specialIssue->conference_date ?: $firstArticle?->published_date;
@endphp

<main class="issue-page">
    <a class="issue-back" href="{{ route('special-issues.index') }}">Back to Special Issues &amp; Conferences</a>

    <section class="issue-overview" aria-labelledby="issue-title">
        @if($specialIssue->cover_image)
            <img class="special-banner" src="{{ asset('storage/' . ltrim($specialIssue->cover_image, '/')) }}" alt="{{ $specialIssue->title }} banner">
        @else
            <div class="special-banner special-banner-placeholder" role="img" aria-label="No banner uploaded">No banner uploaded</div>
        @endif

        <div class="special-overview-body">
            <h1 id="issue-title">{{ $specialIssue->title }}</h1>
            @if($specialIssue->subtitle)<p>{{ $specialIssue->subtitle }}</p>@endif
            @if($specialIssue->about_conference)<p>{{ $specialIssue->about_conference }}</p>@endif

            <div class="issue-stats">
                @if($publishedDate)
                    <span><strong>Published:</strong> {{ $publishedDate->format('d F Y') }}</span>
                @endif
                @if($specialIssue->institution)<span><strong>Institution:</strong> {{ $specialIssue->institution }}</span>@endif
                @if($specialIssue->department)<span><strong>Department:</strong> {{ $specialIssue->department }}</span>@endif
                @if($specialIssue->mode)<span><strong>Mode:</strong> {{ $specialIssue->mode }}</span>@endif
                <span><strong>Total Articles:</strong> {{ $totalArticles }}</span>
                @if($issueIssn)<span><strong>ISSN:</strong> {{ $issueIssn }}</span>@endif
            </div>

            <div class="issue-downloads" aria-label="Issue PDF downloads">
                <a class="{{ $specialIssue->cover_pdf_path ? '' : 'disabled' }}" href="{{ $specialIssue->cover_pdf_path ? route('special-issues.download-cover', $specialIssue) : '#' }}" @if(!$specialIssue->cover_pdf_path) aria-disabled="true" title="Cover PDF not uploaded" @endif>Download Cover (PDF)</a>
                <a class="{{ $specialIssue->index_pdf_path ? '' : 'disabled' }}" href="{{ $specialIssue->index_pdf_path ? route('special-issues.download-index', $specialIssue) : '#' }}" @if(!$specialIssue->index_pdf_path) aria-disabled="true" title="Index PDF not uploaded" @endif>Download Index (PDF)</a>
                <a class="{{ $specialIssue->full_issue_pdf_path ? '' : 'disabled' }}" href="{{ $specialIssue->full_issue_pdf_path ? route('special-issues.download-full-issue', $specialIssue) : '#' }}" @if(!$specialIssue->full_issue_pdf_path) aria-disabled="true" title="Full Issue PDF not uploaded" @endif>Download Full Issue (PDF)</a>
                <a href="{{ route('special-issues.submit-paper', $specialIssue) }}">Submit Paper to this Issue</a>
            </div>
        </div>
    </section>

    @if($specialIssue->editorial_details || $specialIssue->editors->isNotEmpty())
        <section class="special-editorial" aria-labelledby="editorial-details-title">
            <div class="article-heading">
                <h2 id="editorial-details-title">Editorial / Conference Details</h2>
            </div>

            @if($specialIssue->editorial_details)
                <p class="editorial-note">{{ $specialIssue->editorial_details }}</p>
            @endif

            @if($specialIssue->editors->isNotEmpty())
                <div class="editor-grid">
                    @foreach($specialIssue->editors as $editor)
                        <article class="editor-card">
                            @if($editor->photo)
                                <img class="editor-photo" src="{{ asset('storage/' . ltrim($editor->photo, '/')) }}" alt="{{ $editor->name }}">
                            @else
                                <div class="editor-photo editor-photo-placeholder" role="img" aria-label="No photo uploaded">{{ strtoupper(substr($editor->name, 0, 1)) }}</div>
                            @endif
                            <div>
                                <h3>{{ $editor->name }}</h3>
                                @if($editor->position)<p>{{ $editor->position }}</p>@endif
                                @if($editor->department)<p>{{ $editor->department }}</p>@endif
                                @if($editor->institution)<p>{{ $editor->institution }}</p>@endif
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

    <div class="article-heading">
        <h2>Articles in this Issue</h2>
        <span>{{ $totalArticles }} article{{ $totalArticles === 1 ? '' : 's' }}</span>
    </div>

    @forelse($articles as $article)
        @php
            $articleNumber = (($articles->currentPage() - 1) * $articles->perPage()) + $loop->iteration;
            $keywords = preg_split('/[,;]+/', (string) $article->keywords, -1, PREG_SPLIT_NO_EMPTY);
            $pdfExists = $article->final_pdf_path && Storage::disk('public')->exists($article->final_pdf_path);
            $certificateExists = $article->certificate_path && Storage::disk('public')->exists($article->certificate_path);
        @endphp

        <article class="article-row">
            <div class="article-number">{{ str_pad($articleNumber, 2, '0', STR_PAD_LEFT) }}</div>

            <div>
                <span class="article-type">Research Article</span>
                <span class="article-access">Open Access</span>
                <h3>{{ $article->article_title }}</h3>
                <p class="article-authors">{{ $article->main_author }}@if($article->co_authors), {{ $article->co_authors }}@endif</p>

                <div class="article-meta">
                    @if($article->published_date)<span><strong>Published:</strong> {{ $article->published_date->format('Y') }}</span>@endif
                    @if($article->pages)<span><strong>Pages:</strong> {{ $article->pages }}</span>@endif
                    @if($article->paper_id)<span><strong>Paper ID:</strong> {{ $article->paper_id }}</span>@endif
                    @if($article->eissn)<span><strong>eISSN:</strong> {{ $article->eissn }}</span>@endif
                </div>

                @if($article->abstract)
                    <p class="article-abstract">{{ \Illuminate\Support\Str::limit($article->abstract, 270) }}</p>
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
                <a href="{{ route('special-issues.articles.show', [$specialIssue, $article]) }}">View Article</a>
                @if($pdfExists)
                    <a href="{{ route('special-issues.articles.pdf', [$specialIssue, $article]) }}" target="_blank" rel="noopener">Download PDF</a>
                @endif
                @if($certificateExists)
                    <a href="{{ route('special-issues.articles.certificate', [$specialIssue, $article]) }}" target="_blank" rel="noopener">Certificate</a>
                @endif
            </div>
        </article>
    @empty
        <div class="empty-state">No articles are available for this issue.</div>
    @endforelse

    @if($articles->hasPages())
        <div class="mt-4">{{ $articles->links() }}</div>
    @endif
</main>
@endsection
