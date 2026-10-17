@extends('layouts.app')

@section('title', $article->article_title . ' | BJDD Journal')

@push('head')
@php
    $specialArticleUrl = route('special-issues.articles.show', [$specialIssue, $article]);
    $articleDescription = \Illuminate\Support\Str::limit(strip_tags((string) $article->abstract), 155);
@endphp
<link rel="canonical" href="{{ $specialArticleUrl }}">
<meta name="description" content="{{ $articleDescription ?: $article->article_title }}">
@endpush

@push('styles')
<style>
    .article-page { max-width: 1220px; margin: 0 auto; padding: 28px 18px 52px; color: #17221c; }
    .article-back { color: #06452d; text-decoration: none; font-weight: 700; display: inline-block; margin-bottom: 16px; }
    .article-layout { display: grid; grid-template-columns: minmax(0, 1fr) 290px; gap: 24px; align-items: start; }
    .article-tools, .article-section { background: #fff; border: 1px solid #dce5df; border-radius: 7px; }
    .article-main { padding: 24px; background: #fff; border: 1px solid #dce5df; border-radius: 7px; }
    .article-labels { display: flex; flex-wrap: wrap; gap: 7px; margin-bottom: 12px; }
    .article-label { display: inline-block; color: #06452d; background: #eaf5ee; border: 1px solid #b7d8c2; border-radius: 3px; padding: 4px 8px; font-size: .68rem; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; }
    .article-label-open { color: #8a4d00; background: #fff6df; border-color: #e4c278; }
    .article-main h1 { color: #06452d; font-size: 2.2rem; line-height: 1.25; margin: 0 0 10px; overflow-wrap: anywhere; }
    .article-authors { color: #34443a; font-size: .98rem; margin: 0 0 18px; }
    .article-affiliation { color: #59665f; margin: -8px 0 18px; }
    .article-metadata { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); border-top: 1px solid #dce5df; border-bottom: 1px solid #dce5df; margin: 0 0 22px; }
    .metadata-item { min-width: 0; padding: 12px 11px; border-right: 1px solid #dce5df; }
    .metadata-item:nth-child(3n) { border-right: 0; }
    .metadata-item strong, .metadata-item span { display: block; }
    .metadata-item strong { color: #59665f; font-size: .7rem; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 4px; }
    .metadata-item span, .metadata-item a { color: #17221c; font-size: .84rem; overflow-wrap: anywhere; }
    .metadata-item a { color: #0b6b42; text-decoration: none; }
    .article-section { padding: 18px; margin-top: 16px; }
    .article-section h2 { color: #06452d; font-size: 1.15rem; margin: 0 0 11px; }
    .article-section p { color: #34443a; line-height: 1.7; margin: 0; overflow-wrap: anywhere; }
    .keyword-list { display: flex; flex-wrap: wrap; gap: 6px; }
    .keyword { color: #496055; background: #f1f6f2; border: 1px solid #d7e4da; border-radius: 3px; padding: 5px 8px; font-size: .82rem; }
    .article-tools { padding: 16px; position: sticky; top: 18px; }
    .article-tools h2 { color: #06452d; font-size: 1rem; margin: 0 0 12px; padding-bottom: 8px; border-bottom: 2px solid #c47d18; }
    .tool-link, .tool-button { display: block; width: 100%; border: 1px solid #9bb3a4; border-radius: 4px; padding: 8px 10px; margin-top: 8px; color: #06452d; background: #fff; font: inherit; font-size: .82rem; font-weight: 700; text-align: left; text-decoration: none; cursor: pointer; }
    .tool-link-primary { color: #fff; background: #06452d; border-color: #06452d; }
    .tool-link:hover, .tool-button:hover { border-color: #c47d18; }
    .article-sidebar-section { border-top: 1px solid #dce5df; margin-top: 18px; padding-top: 16px; }
    .article-sidebar-section h2 { color: #06452d; font-size: .98rem; margin: 0 0 12px; padding-bottom: 8px; border-bottom: 2px solid #a9c5b5; }
    .article-detail-list { display: grid; gap: 10px; margin: 0; }
    .article-detail-item dt { color: #59665f; font-size: .68rem; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; }
    .article-detail-item dd { color: #17221c; font-size: .82rem; line-height: 1.4; margin: 2px 0 0; overflow-wrap: anywhere; }
    .article-history { display: grid; gap: 8px; margin: 0; padding: 0; list-style: none; }
    .article-history-item { display: grid; grid-template-columns: 9px minmax(0, 1fr); gap: 9px; align-items: start; color: #34443a; font-size: .82rem; }
    .article-history-item::before { content: ''; width: 8px; height: 8px; margin-top: 4px; border: 2px solid #0b6b42; border-radius: 50%; box-sizing: border-box; }
    .article-history-item strong { display: block; color: #17221c; font-size: .78rem; }
    .article-history-item span { color: #59665f; }
    .article-metrics { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; }
    .article-metric { border: 1px solid #dce5df; border-radius: 4px; padding: 10px 8px; text-align: center; }
    .article-metric strong, .article-metric span { display: block; }
    .article-metric strong { color: #59665f; font-size: .68rem; line-height: 1.3; }
    .article-metric span { color: #0b6b42; font-size: 1.35rem; font-weight: 800; margin-top: 3px; }
    .metrics-note { color: #66746c; font-size: .72rem; line-height: 1.4; margin-top: 8px; }
    .share-links { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 7px; }
    .share-links a, .share-button { display: block; width: 100%; border: 1px solid #9bb3a4; border-radius: 4px; padding: 7px 6px; color: #06452d; background: #fff; font: inherit; font-size: .76rem; font-weight: 700; text-align: center; text-decoration: none; cursor: pointer; }
    .share-button { margin-bottom: 7px; color: #fff; background: #06452d; border-color: #06452d; }
    .share-links a:hover, .share-button:hover { border-color: #c47d18; }
    .citation-controls { display: flex; gap: 8px; align-items: center; margin-bottom: 10px; }
    .citation-controls select { min-width: 0; flex: 1; border: 1px solid #cbd8d0; border-radius: 4px; padding: 7px 8px; background: #fff; }
    .citation-copy { color: #fff; background: #06452d; border: 1px solid #06452d; border-radius: 4px; padding: 7px 10px; font-size: .8rem; font-weight: 700; white-space: nowrap; cursor: pointer; }
    .citation-output { color: #34443a; background: #fbfdfb; border: 1px solid #dce5df; border-radius: 4px; padding: 12px; line-height: 1.6; overflow-wrap: anywhere; }
    .citation-status { min-height: 1.1em; color: #0b6b42; font-size: .78rem; margin-top: 7px; }
    .rights-copy { display: grid; gap: 12px; }
    .rights-copy strong, .rights-copy a { color: #06452d; }
    .rights-copy a { text-decoration: underline; }
    @media (max-width: 900px) { .article-layout { grid-template-columns: 1fr; } .article-tools { position: static; order: -1; } }
    @media (max-width: 620px) {
        .article-page { padding: 20px 12px 34px; }
        .article-main { padding: 17px; }
        .article-main h1 { font-size: 1.7rem; }
        .article-metadata { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .metadata-item:nth-child(3n) { border-right: 1px solid #dce5df; }
        .metadata-item:nth-child(2n) { border-right: 0; }
    }
</style>
@endpush

@section('content')
@php
    use App\Support\ArticleHelper;
    $doiUrl = ArticleHelper::doiUrl($article->doi);
    $keywords = preg_split('/[,;]+/', (string) $article->keywords, -1, PREG_SPLIT_NO_EMPTY);
    $pdfExists = $article->final_pdf_path && Storage::disk('public')->exists($article->final_pdf_path);
    $certificateExists = $article->certificate_path && Storage::disk('public')->exists($article->certificate_path);
    $publishedOnlineAt = $article->published_date ?: $article->updated_at;
    $articleIssn = $article->eissn ?: '3139-1486 (Online)';
    $citation = $article->main_author . '. (' . optional($publishedOnlineAt)->format('Y') . '). ' . $article->article_title . '. ' . $specialIssue->title . '.';
    $shareTitle = rawurlencode($article->article_title);
    $shareUrl = rawurlencode($specialArticleUrl);
@endphp

<main class="article-page">
    <a class="article-back" href="{{ route('special-issues.show', $specialIssue) }}">&larr; Back to {{ $specialIssue->title }}</a>

    <div class="article-layout">
        <article class="article-main">
            <div class="article-labels"><span class="article-label">Research Article</span><span class="article-label article-label-open">Open Access</span></div>
            <h1>{{ $article->article_title }}</h1>
            <p class="article-authors">{{ $article->main_author }}@if($article->co_authors), {{ $article->co_authors }}@endif</p>
            @if($article->affiliation || $article->country)<p class="article-affiliation">{{ $article->affiliation }}@if($article->affiliation && $article->country) &middot; @endif{{ $article->country }}</p>@endif

            <div class="article-metadata" aria-label="Article metadata">
                @if($article->published_date)<div class="metadata-item"><strong>Published</strong><span>{{ $article->published_date->format('d M Y') }}</span></div>@endif
                @if($article->pages)<div class="metadata-item"><strong>Pages</strong><span>{{ $article->pages }}</span></div>@endif
                @if($article->paper_id)<div class="metadata-item"><strong>Paper ID</strong><span>{{ $article->paper_id }}</span></div>@endif
                @if($doiUrl)<div class="metadata-item"><strong>DOI</strong><a href="{{ $doiUrl }}" target="_blank" rel="noopener">{{ ArticleHelper::normalizeDoi($article->doi) }}</a></div>@endif
                @if($article->eissn)<div class="metadata-item"><strong>eISSN</strong><span>{{ $article->eissn }}</span></div>@endif
                @if($article->language)<div class="metadata-item"><strong>Language</strong><span>{{ $article->language }}</span></div>@endif
                @if($article->country)<div class="metadata-item"><strong>Country</strong><span>{{ $article->country }}</span></div>@endif
            </div>

            @if($article->abstract)<section class="article-section" aria-labelledby="abstract-title"><h2 id="abstract-title">Abstract</h2><p>{{ $article->abstract }}</p></section>@endif
            @if(count($keywords))<section class="article-section" aria-labelledby="keywords-title"><h2 id="keywords-title">Keywords</h2><div class="keyword-list">@foreach($keywords as $keyword)<span class="keyword">{{ trim($keyword) }}</span>@endforeach</div></section>@endif

            <section class="article-section" aria-labelledby="citation-title">
                <h2 id="citation-title">How to Cite This Article</h2>
                <div class="citation-controls"><label class="visually-hidden" for="citation-style">Citation style</label><select id="citation-style"><option value="apa">APA 7</option></select><button class="citation-copy" type="button" id="copy-citation">Copy</button></div>
                <div class="citation-output" id="citation-output">{{ $citation }}</div><div class="citation-status" id="citation-status" aria-live="polite"></div>
            </section>

            <section class="article-section" aria-labelledby="rights-title"><h2 id="rights-title">Rights</h2><div class="rights-copy"><div><strong>License</strong><br><a href="https://creativecommons.org/licenses/by/4.0/" target="_blank" rel="noopener">Creative Commons Attribution 4.0 International (CC BY 4.0)</a></div><div><strong>Copyright</strong><br>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</div></div></section>
        </article>

        <aside class="article-tools" aria-label="Article tools">
            <h2>Article Tools</h2>
            @if($pdfExists)<a class="tool-link tool-link-primary" href="{{ route('special-issues.articles.pdf', [$specialIssue, $article]) }}" target="_blank" rel="noopener">Download PDF</a>@endif
            @if($certificateExists)<a class="tool-link" href="{{ route('special-issues.articles.certificate', [$specialIssue, $article]) }}" target="_blank" rel="noopener">Download Certificate</a>@endif
            @if($doiUrl)<a class="tool-link" href="{{ $doiUrl }}" target="_blank" rel="noopener">View DOI</a>@endif
            <a class="tool-link" href="#citation-title">Cite This Article</a>
            <button class="tool-button" type="button" id="copy-article-link">Copy Article Link</button><div class="citation-status" id="link-status" aria-live="polite"></div>

            <section class="article-sidebar-section" aria-labelledby="article-details-title"><h2 id="article-details-title">Article Details</h2><dl class="article-detail-list"><div class="article-detail-item"><dt>Article Type</dt><dd>{{ $article->article_type ?: 'Research Article' }}</dd></div><div class="article-detail-item"><dt>ISSN</dt><dd>{{ $articleIssn }}</dd></div><div class="article-detail-item"><dt>Publisher</dt><dd>{{ $article->publisher ?: 'BJDD Journal' }}</dd></div><div class="article-detail-item"><dt>Language</dt><dd>{{ $article->language ?: 'English' }}</dd></div><div class="article-detail-item"><dt>Last Updated</dt><dd>{{ optional($article->updated_at)->format('d F Y') ?: 'Not recorded' }}</dd></div></dl></section>

            <section class="article-sidebar-section" aria-labelledby="article-history-title"><h2 id="article-history-title">Article History</h2><ul class="article-history"><li class="article-history-item"><div><strong>Published Online</strong><span>{{ optional($publishedOnlineAt)->format('d F Y') ?: 'Not recorded' }}</span></div></li></ul></section>

            <section class="article-sidebar-section" aria-labelledby="article-metrics-title"><h2 id="article-metrics-title">Article Metrics</h2><div class="article-metrics"><div class="article-metric"><strong>Article Views</strong><span>{{ number_format((int) ($article->view_count ?? 0)) }}</span></div><div class="article-metric"><strong>PDF Downloads</strong><span>{{ number_format((int) ($article->download_count ?? 0)) }}</span></div></div><div class="metrics-note">Metrics are updated in real time.</div></section>

            <section class="article-sidebar-section" aria-labelledby="share-article-title"><h2 id="share-article-title">Share This Article</h2><button class="share-button" type="button" id="share-article">Share Article</button><div class="share-links"><a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener">Facebook</a><a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener">LinkedIn</a><a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener">WhatsApp</a><a href="mailto:?subject={{ $shareTitle }}&body={{ $shareUrl }}">Email</a></div></section>
        </aside>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const citation = @json($citation), articleUrl = @json($specialArticleUrl), citationStatus = document.getElementById('citation-status'), linkStatus = document.getElementById('link-status');
        const copyText = function (value, statusElement) { const complete = function () { statusElement.textContent = 'Copied.'; }; if (navigator.clipboard && window.isSecureContext) { navigator.clipboard.writeText(value).then(complete); return; } const helper = document.createElement('textarea'); helper.value = value; helper.style.position = 'fixed'; helper.style.opacity = '0'; document.body.appendChild(helper); helper.select(); document.execCommand('copy'); document.body.removeChild(helper); complete(); };
        document.getElementById('copy-citation')?.addEventListener('click', function () { copyText(citation, citationStatus); });
        document.getElementById('copy-article-link')?.addEventListener('click', function () { copyText(articleUrl, linkStatus); });
        document.getElementById('share-article')?.addEventListener('click', function () { if (navigator.share) { navigator.share({ title: @json($article->article_title), url: articleUrl); } else { copyText(articleUrl, linkStatus); } });
    });
</script>
@endsection
