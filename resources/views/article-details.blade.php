@extends('layouts.app')

@section('title', $publication->paper_title . ' | BJDD Journal')

@push('head')
@php
    $canonicalArticleUrl = route('article.details', ['publicationKey' => $articleKey]);
    $articleDescription = \Illuminate\Support\Str::limit(strip_tags((string) $publication->abstract), 155);
@endphp
<link rel="canonical" href="{{ $canonicalArticleUrl }}">
<meta name="description" content="{{ $articleDescription ?: $publication->paper_title }}">
@endpush

@push('styles')
<style>
    .article-page {
        max-width: 1220px;
        margin: 0 auto;
        padding: 28px 18px 52px;
        color: #17221c;
    }

    .article-back {
        color: #06452d;
        text-decoration: none;
        font-weight: 700;
        display: inline-block;
        margin-bottom: 16px;
    }

    .article-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 290px;
        gap: 24px;
        align-items: start;
    }

    .article-tools,
    .article-section {
        background: #fff;
        border: 1px solid #dce5df;
        border-radius: 7px;
    }

    .article-main {
        padding: 24px;
    }

    .article-labels {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-bottom: 12px;
    }

    .article-label {
        display: inline-block;
        color: #06452d;
        background: #eaf5ee;
        border: 1px solid #b7d8c2;
        border-radius: 3px;
        padding: 4px 8px;
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .article-label-open {
        color: #8a4d00;
        background: #fff6df;
        border-color: #e4c278;
    }

    .article-main h1 {
        color: #06452d;
        font-size: 2.2rem;
        line-height: 1.25;
        margin: 0 0 10px;
        overflow-wrap: anywhere;
    }

    .article-authors {
        color: #34443a;
        font-size: .98rem;
        margin: 0 0 18px;
    }

    .article-metadata {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        border-top: 1px solid #dce5df;
        border-bottom: 1px solid #dce5df;
        margin: 0 0 22px;
    }

    .metadata-item {
        min-width: 0;
        padding: 12px 11px;
        border-right: 1px solid #dce5df;
    }

    .metadata-item:nth-child(3n) {
        border-right: 0;
    }

    .metadata-item strong,
    .metadata-item span {
        display: block;
    }

    .metadata-item strong {
        color: #59665f;
        font-size: .7rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-bottom: 4px;
    }

    .metadata-item span,
    .metadata-item a {
        color: #17221c;
        font-size: .84rem;
        overflow-wrap: anywhere;
    }

    .metadata-item a {
        color: #0b6b42;
        text-decoration: none;
    }

    .article-section {
        padding: 18px;
        margin-top: 16px;
    }

    .article-section h2 {
        color: #06452d;
        font-size: 1.15rem;
        margin: 0 0 11px;
    }

    .article-section p {
        color: #34443a;
        line-height: 1.7;
        margin: 0;
        overflow-wrap: anywhere;
    }

    .keyword-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .keyword {
        color: #496055;
        background: #f1f6f2;
        border: 1px solid #d7e4da;
        border-radius: 3px;
        padding: 5px 8px;
        font-size: .82rem;
    }

    .article-tools {
        padding: 16px;
        position: sticky;
        top: 18px;
    }

    .article-tools h2 {
        color: #06452d;
        font-size: 1rem;
        margin: 0 0 12px;
        padding-bottom: 8px;
        border-bottom: 2px solid #c47d18;
    }

    .tool-link,
    .tool-button {
        display: block;
        width: 100%;
        border: 1px solid #9bb3a4;
        border-radius: 4px;
        padding: 8px 10px;
        margin-top: 8px;
        color: #06452d;
        background: #fff;
        font: inherit;
        font-size: .82rem;
        font-weight: 700;
        text-align: left;
        text-decoration: none;
        cursor: pointer;
    }

    .tool-link-primary {
        color: #fff;
        background: #06452d;
        border-color: #06452d;
    }

    .tool-link:hover,
    .tool-button:hover {
        border-color: #c47d18;
    }

    .article-sidebar-section {
        border-top: 1px solid #dce5df;
        margin-top: 18px;
        padding-top: 16px;
    }

    .article-sidebar-section h2 {
        color: #06452d;
        font-size: .98rem;
        margin: 0 0 12px;
        padding-bottom: 8px;
        border-bottom: 2px solid #a9c5b5;
    }

    .article-detail-list {
        display: grid;
        gap: 10px;
        margin: 0;
    }

    .article-detail-item dt {
        color: #59665f;
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .article-detail-item dd {
        color: #17221c;
        font-size: .82rem;
        line-height: 1.4;
        margin: 2px 0 0;
        overflow-wrap: anywhere;
    }

    .article-history {
        display: grid;
        gap: 8px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .article-history-item {
        display: grid;
        grid-template-columns: 9px minmax(0, 1fr);
        gap: 9px;
        align-items: start;
        color: #34443a;
        font-size: .82rem;
    }

    .article-history-item::before {
        content: '';
        width: 8px;
        height: 8px;
        margin-top: 4px;
        border: 2px solid #0b6b42;
        border-radius: 50%;
        box-sizing: border-box;
    }

    .article-history-item strong {
        display: block;
        color: #17221c;
        font-size: .78rem;
    }

    .article-history-item span {
        color: #59665f;
    }

    .article-metrics {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
    }

    .article-metric {
        border: 1px solid #dce5df;
        border-radius: 4px;
        padding: 10px 8px;
        text-align: center;
    }

    .article-metric strong,
    .article-metric span {
        display: block;
    }

    .article-metric strong {
        color: #59665f;
        font-size: .68rem;
        line-height: 1.3;
    }

    .article-metric span {
        color: #0b6b42;
        font-size: 1.35rem;
        font-weight: 800;
        margin-top: 3px;
    }

    .metrics-note {
        color: #66746c;
        font-size: .72rem;
        line-height: 1.4;
        margin-top: 8px;
    }

    .share-links {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 7px;
    }

    .share-links a,
    .share-button {
        display: block;
        width: 100%;
        border: 1px solid #9bb3a4;
        border-radius: 4px;
        padding: 7px 6px;
        color: #06452d;
        background: #fff;
        font: inherit;
        font-size: .76rem;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
    }

    .share-button {
        margin-bottom: 7px;
        color: #fff;
        background: #06452d;
        border-color: #06452d;
    }

    .share-links a:hover,
    .share-button:hover {
        border-color: #c47d18;
    }

    .article-nav {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-top: 18px;
    }

    .article-nav-link {
        min-width: 0;
        border: 1px solid #dce5df;
        border-radius: 5px;
        padding: 12px;
        color: #06452d;
        text-decoration: none;
    }

    .article-nav-link.next {
        text-align: right;
    }

    .article-nav-link span,
    .related-card span {
        display: block;
        color: #66746c;
        font-size: .72rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .article-nav-link strong {
        display: block;
        overflow-wrap: anywhere;
    }

    .related-section {
        margin-top: 28px;
    }

    .related-section h2 {
        color: #06452d;
        font-size: 1.25rem;
        border-bottom: 1px solid #a9c5b5;
        margin: 0 0 14px;
        padding-bottom: 8px;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .related-card {
        min-width: 0;
        border: 1px solid #dce5df;
        border-radius: 5px;
        padding: 14px;
        background: #fff;
        text-decoration: none;
    }

    .related-card h3 {
        color: #06452d;
        font-size: .98rem;
        line-height: 1.4;
        margin: 0 0 7px;
        overflow-wrap: anywhere;
    }

    .related-card p {
        color: #59665f;
        font-size: .8rem;
        line-height: 1.45;
        margin: 0;
        overflow-wrap: anywhere;
    }

    .citation-controls {
        display: flex;
        gap: 8px;
        align-items: center;
        margin-bottom: 10px;
    }

    .citation-controls select {
        min-width: 0;
        flex: 1;
        border: 1px solid #cbd8d0;
        border-radius: 4px;
        padding: 7px 8px;
        background: #fff;
    }

    .citation-copy {
        color: #fff;
        background: #06452d;
        border: 1px solid #06452d;
        border-radius: 4px;
        padding: 7px 10px;
        font-size: .8rem;
        font-weight: 700;
        white-space: nowrap;
        cursor: pointer;
    }

    .citation-output {
        color: #34443a;
        background: #fbfdfb;
        border: 1px solid #dce5df;
        border-radius: 4px;
        padding: 12px;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    .citation-status {
        min-height: 1.1em;
        color: #0b6b42;
        font-size: .78rem;
        margin-top: 7px;
    }

    .rights-copy {
        display: grid;
        gap: 12px;
    }

    .rights-copy strong,
    .rights-copy a {
        color: #06452d;
    }

    .rights-copy a {
        text-decoration: underline;
    }

    @media (max-width: 900px) {
        .article-layout {
            grid-template-columns: 1fr;
        }

        .article-tools {
            position: static;
            order: -1;
        }
    }

    @media (max-width: 620px) {
        .article-page {
            padding: 20px 12px 34px;
        }

        .article-main {
            padding: 17px;
        }

        .article-main h1 {
            font-size: 1.7rem;
        }

        .article-metadata {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .metadata-item:nth-child(3n) {
            border-right: 1px solid #dce5df;
        }

        .metadata-item:nth-child(2n) {
            border-right: 0;
        }

        .article-nav,
        .related-grid {
            grid-template-columns: 1fr;
        }

        .article-nav-link.next {
            text-align: left;
        }
    }
</style>
@endpush

@section('content')
@php
    use App\Support\ArticleHelper;
    $doiUrl = ArticleHelper::doiUrl($publication->crossref_doi);
    $keywords = preg_split('/[,;]+/', (string) $publication->keywords, -1, PREG_SPLIT_NO_EMPTY);
    $pdfExists = $publication->paper_pdf && Storage::disk('public')->exists($publication->paper_pdf);
    $certificateExists = $publication->certificate_path && Storage::disk('public')->exists($publication->certificate_path);
    $lastUpdated = $publication->updated_at ?: $publication->created_at;
    $publishedOnlineAt = $publication->published_online_at ?: $lastUpdated;
    $articleIssn = $publication->eissn ?: '3139-1486 (Online)';
    $articleType = $publication->article_type ?: 'Research Article';
    $publicationType = $publication->publication_type ?: 'Peer Reviewed Journal';
    $publisher = $publication->publisher ?: 'BODHIVRUKSHA Publication';
    $frequency = $publication->frequency ?: 'Bi-monthly';
    $language = $publication->language ?: 'English';
    $shareTitle = rawurlencode($publication->paper_title);
    $shareUrl = rawurlencode($canonicalArticleUrl);
@endphp

<main class="article-page">
    <a class="article-back" href="{{ route('archive.issue', ['volume' => $publication->volume, 'issue' => $publication->issue]) }}">Back to Issue</a>

    <div class="article-layout">
        <article class="article-main">
            <div class="article-labels">
                <span class="article-label">Research Article</span>
                <span class="article-label article-label-open">Open Access</span>
            </div>

            <h1>{{ $publication->paper_title }}</h1>
            <p class="article-authors">{{ implode(', ', ArticleHelper::authors($publication->author_name)) }}</p>

            <div class="article-metadata" aria-label="Article metadata">
                @if($publication->volume)<div class="metadata-item"><strong>Volume / Issue</strong><span>Volume {{ $publication->volume }}, Issue {{ $publication->issue }}</span></div>@endif
                @if($publication->year)<div class="metadata-item"><strong>Published</strong><span>{{ $publication->year }}</span></div>@endif
                @if($publication->page_nos)<div class="metadata-item"><strong>Pages</strong><span>{{ $publication->page_nos }}</span></div>@endif
                @if($publication->registration_id)<div class="metadata-item"><strong>Registration ID</strong><span>{{ $publication->registration_id }}</span></div>@endif
                @if($publication->published_paper_id)<div class="metadata-item"><strong>Paper ID</strong><span>{{ $publication->published_paper_id }}</span></div>@endif
                @if($doiUrl)<div class="metadata-item"><strong>DOI</strong><a href="{{ $doiUrl }}" target="_blank" rel="noopener">{{ ArticleHelper::normalizeDoi($publication->crossref_doi) }}</a></div>@endif
                @if($publication->eissn)<div class="metadata-item"><strong>eISSN</strong><span>{{ $publication->eissn }}</span></div>@endif
                @if($publication->country)<div class="metadata-item"><strong>Country</strong><span>{{ $publication->country }}</span></div>@endif
            </div>

            @if($publication->abstract)
                <section class="article-section" aria-labelledby="abstract-title">
                    <h2 id="abstract-title">Abstract</h2>
                    <p>{{ $publication->abstract }}</p>
                </section>
            @endif

            @if(count($keywords))
                <section class="article-section" aria-labelledby="keywords-title">
                    <h2 id="keywords-title">Keywords</h2>
                    <div class="keyword-list">
                        @foreach($keywords as $keyword)
                            <span class="keyword">{{ trim($keyword) }}</span>
                        @endforeach
                    </div>
                </section>
            @endif

            <section class="article-section" aria-labelledby="citation-title">
                <h2 id="citation-title">How to Cite This Article</h2>
                <div class="citation-controls">
                    <label class="visually-hidden" for="citation-style">Citation style</label>
                    <select id="citation-style">
                        @foreach($citations as $style => $citation)
                            <option value="{{ $style }}">{{ $style }}</option>
                        @endforeach
                    </select>
                    <button class="citation-copy" type="button" id="copy-citation">Copy</button>
                </div>
                <div class="citation-output" id="citation-output">{{ $citations['APA 7'] ?? '' }}</div>
                <div class="citation-status" id="citation-status" aria-live="polite"></div>
            </section>

            <section class="article-section" aria-labelledby="rights-title">
                <h2 id="rights-title">Rights</h2>
                <div class="rights-copy">
                    <div><strong>License</strong><br><a href="https://creativecommons.org/licenses/by/4.0/" target="_blank" rel="noopener">Creative Commons Attribution 4.0 International (CC BY 4.0)</a></div>
                    <div><strong>Copyright</strong><br>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</div>
                </div>
            </section>

            @if($previousArticle || $nextArticle)
                <nav class="article-nav" aria-label="Article navigation">
                    @if($previousArticle)
                        <a class="article-nav-link" href="{{ route('article.details', ['publicationKey' => ArticleHelper::routeKey($previousArticle)]) }}">
                            <span>Previous Article</span>
                            <strong>{{ $previousArticle->paper_title }}</strong>
                        </a>
                    @else
                        <div></div>
                    @endif
                    @if($nextArticle)
                        <a class="article-nav-link next" href="{{ route('article.details', ['publicationKey' => ArticleHelper::routeKey($nextArticle)]) }}">
                            <span>Next Article</span>
                            <strong>{{ $nextArticle->paper_title }}</strong>
                        </a>
                    @endif
                </nav>
            @endif
        </article>

        <aside class="article-tools" aria-label="Article tools">
            <h2>Article Tools</h2>
            @if($pdfExists)
                <a class="tool-link tool-link-primary" href="{{ route('publications.download', $publication->id) }}">Download PDF</a>
            @endif
            @if($certificateExists)
                <a class="tool-link" href="{{ asset('storage/' . ltrim($publication->certificate_path, '/')) }}" target="_blank" rel="noopener">Download Certificate</a>
            @endif
            @if($doiUrl)
                <a class="tool-link" href="{{ $doiUrl }}" target="_blank" rel="noopener">View DOI</a>
            @endif
            @if($publication->paper_url)
                <a class="tool-link" href="{{ $publication->paper_url }}" target="_blank" rel="noopener">Published Paper URL</a>
            @endif
            <a class="tool-link" href="#citation-title">Cite This Article</a>
            <button class="tool-button" type="button" id="copy-article-link">Copy Article Link</button>
            <div class="citation-status" id="link-status" aria-live="polite"></div>

            <section class="article-sidebar-section" aria-labelledby="article-details-title">
                <h2 id="article-details-title">Article Details</h2>
                <dl class="article-detail-list">
                    <div class="article-detail-item"><dt>Article Type</dt><dd>{{ $articleType }}</dd></div>
                    <div class="article-detail-item"><dt>Publication</dt><dd>{{ $publicationType }}</dd></div>
                    <div class="article-detail-item"><dt>ISSN</dt><dd>{{ $articleIssn }}</dd></div>
                    <div class="article-detail-item"><dt>Publisher</dt><dd>{{ $publisher }}</dd></div>
                    <div class="article-detail-item"><dt>Frequency</dt><dd>{{ $frequency }}</dd></div>
                    <div class="article-detail-item"><dt>Language</dt><dd>{{ $language }}</dd></div>
                    <div class="article-detail-item"><dt>Last Updated</dt><dd>{{ optional($lastUpdated)->format('d F Y') ?: 'Not recorded' }}</dd></div>
                </dl>
            </section>

            <section class="article-sidebar-section" aria-labelledby="article-history-title">
                <h2 id="article-history-title">Article History</h2>
                <ul class="article-history">
                    <li class="article-history-item"><div><strong>Received</strong><span>{{ optional($publication->received_at)->format('d F Y') ?: 'Not recorded' }}</span></div></li>
                    <li class="article-history-item"><div><strong>Revised</strong><span>{{ optional($publication->revised_at)->format('d F Y') ?: 'Not recorded' }}</span></div></li>
                    <li class="article-history-item"><div><strong>Accepted</strong><span>{{ optional($publication->accepted_at)->format('d F Y') ?: 'Not recorded' }}</span></div></li>
                    <li class="article-history-item"><div><strong>Published Online</strong><span>{{ optional($publishedOnlineAt)->format('d F Y') ?: 'Not recorded' }}</span></div></li>
                </ul>
            </section>

            <section class="article-sidebar-section" aria-labelledby="article-metrics-title">
                <h2 id="article-metrics-title">Article Metrics</h2>
                <div class="article-metrics">
                    <div class="article-metric"><strong>Article Views</strong><span>{{ number_format((int) ($publication->view_count ?? 0)) }}</span></div>
                    <div class="article-metric"><strong>PDF Downloads</strong><span>{{ number_format((int) ($publication->download_count ?? 0)) }}</span></div>
                </div>
                <div class="metrics-note">Metrics are updated in real time.</div>
            </section>

            <section class="article-sidebar-section" aria-labelledby="share-article-title">
                <h2 id="share-article-title">Share This Article</h2>
                <button class="share-button" type="button" id="share-article">Share Article</button>
                <div class="share-links">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener">Facebook</a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener">LinkedIn</a>
                    <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener">WhatsApp</a>
                    <a href="mailto:?subject={{ $shareTitle }}&body={{ $shareUrl }}">Email</a>
                </div>
            </section>
        </aside>
    </div>

    @if($moreArticles->isNotEmpty())
        <section class="related-section" aria-labelledby="related-articles-title">
            <h2 id="related-articles-title">More from Volume {{ $publication->volume }}, Issue {{ $publication->issue }}</h2>
            <div class="related-grid">
                @foreach($moreArticles as $relatedArticle)
                    <a class="related-card" href="{{ route('article.details', ['publicationKey' => ArticleHelper::routeKey($relatedArticle)]) }}">
                        <span>{{ $relatedArticle->page_nos ? 'Pages ' . $relatedArticle->page_nos : 'Research Article' }}</span>
                        <h3>{{ $relatedArticle->paper_title }}</h3>
                        <p>{{ implode(', ', array_slice(ArticleHelper::authors($relatedArticle->author_name), 0, 2)) }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const citations = @json($citations);
        const styleSelect = document.getElementById('citation-style');
        const citationOutput = document.getElementById('citation-output');
        const citationStatus = document.getElementById('citation-status');
        const linkStatus = document.getElementById('link-status');
        const shareButton = document.getElementById('share-article');

        styleSelect.addEventListener('change', function () {
            citationOutput.textContent = citations[this.value] || '';
            citationStatus.textContent = '';
        });

        function copyText(value, statusElement) {
            const complete = function () {
                statusElement.textContent = 'Copied.';
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(value).then(complete);
                return;
            }

            const helper = document.createElement('textarea');
            helper.value = value;
            helper.style.position = 'fixed';
            helper.style.opacity = '0';
            document.body.appendChild(helper);
            helper.select();
            document.execCommand('copy');
            helper.remove();
            complete();
        }

        document.getElementById('copy-citation').addEventListener('click', function () {
            copyText(citationOutput.textContent, citationStatus);
        });

        document.getElementById('copy-article-link').addEventListener('click', function () {
            copyText(@json($canonicalArticleUrl), linkStatus);
        });

        if (shareButton) {
            if (navigator.share) {
                shareButton.addEventListener('click', function () {
                    navigator.share({
                        title: @json($publication->paper_title),
                        text: 'Read this article from BJDD Journal',
                        url: @json($canonicalArticleUrl)
                    }).catch(function () {});
                });
            } else {
                shareButton.hidden = true;
            }
        }
    });
</script>
@endsection
