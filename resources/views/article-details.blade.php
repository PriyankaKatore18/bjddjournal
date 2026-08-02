@extends('layouts.app')

@section('content')

<div class="container py-5">

    <a href="{{ url()->previous() }}"
        class="btn btn-outline-secondary mb-4">
        ← Back
    </a>

    <div class="card shadow-sm border-0">

        <div class="card-body p-5">

            <span class="badge bg-success mb-3">
                Research Paper
            </span>

            <h1 class="mb-3">
                {{ $publication->paper_title }}
            </h1>

            <h5 class="text-muted mb-4">
                {{ $publication->author_name }}
            </h5>

            <hr>

            @if($publication->keywords)
            <div class="mb-4">
                <h5>Keywords</h5>

                @foreach(explode(',', $publication->keywords) as $keyword)
                <span class="badge bg-light text-dark border me-2 mb-2">
                    {{ trim($keyword) }}
                </span>
                @endforeach
            </div>
            @endif

            <div class="mb-4">
                <strong>Registration ID:</strong>
                {{ $publication->registration_id }}
            </div>

            <div class="mb-4">
                <strong>Published Paper ID:</strong>
                {{ $publication->published_paper_id }}
            </div>

            <div class="mb-4">
                <strong>Volume:</strong>
                {{ $publication->volume }}
            </div>

            <div class="mb-4">
                <strong>Issue:</strong>
                {{ $publication->issue }}
            </div>

            <div class="mb-4">
                <strong>Year:</strong>
                {{ $publication->year }}
            </div>

            <div class="mb-4">
                <strong>Country:</strong>
                {{ $publication->country }}
            </div>

            @if($publication->crossref_doi)
            <div class="mb-4">
                <strong>DOI:</strong>

                <a href="{{ $publication->crossref_doi }}"
                    target="_blank">
                    {{ $publication->crossref_doi }}
                </a>
            </div>
            @endif

            @if($publication->abstract)
            <div class="mb-4">
                <h4>Abstract</h4>

                <p style="line-height:1.9;">
                    {{ $publication->abstract }}
                </p>
            </div>
            @endif

            <div class="mb-4">
                <strong>Page No:</strong>
                {{ $publication->page_nos }}
            </div>

            <div class="d-flex gap-2 flex-wrap">

                @if($publication->paper_pdf)
                <a href="{{ route('publications.viewPdf', $publication->id) }}"
                    target="_blank"
                    class="btn btn-danger">
                    Download PDF
                </a>
                @endif

                @if($publication->certificate_path)
                <a href="{{ asset('storage/'.$publication->certificate_path) }}"
                    target="_blank"
                    class="btn btn-success">
                    Download Certificate
                </a>
                @endif

            </div>

        </div>

    </div>

</div>

@endsection