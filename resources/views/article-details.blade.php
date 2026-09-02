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
        grid-template-columns: minmax(0, 1fr) 250px;
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
        </article>

        <aside class="article-tools" aria-label="Article tools">
            <h2>Article Tools</h2>
            @if($pdfExists)
                <a class="tool-link tool-link-primary" href="{{ route('publications.viewPdf', $publication->id) }}" target="_blank" rel="noopener">Download PDF</a>
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
            <button class="tool-button" type="button" id="copy-article-link">Copy Article Link</button>
            <div class="citation-status" id="link-status" aria-live="polite"></div>
        </aside>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const citations = @json($citations);
        const styleSelect = document.getElementById('citation-style');
        const citationOutput = document.getElementById('citation-output');
        const citationStatus = document.getElementById('citation-status');
        const linkStatus = document.getElementById('link-status');

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
    });
</script>
@endsection
