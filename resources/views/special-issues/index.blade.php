@extends('layouts.app')

@section('title', 'Special Issues & Conferences | BJDD Journal')

@section('content')
<style>
    .special-hero { background: linear-gradient(135deg, #00004d, #143a70); color: #fff; border-radius: 18px; padding: 42px 36px; margin-bottom: 28px; }
    .special-card { height: 100%; border: 1px solid #e4e8f0; border-radius: 16px; overflow: hidden; background: #fff; box-shadow: 0 10px 24px rgba(15, 23, 42, .07); }
    .special-card-cover { height: 170px; width: 100%; object-fit: cover; background: linear-gradient(135deg, #eef2ff, #dbeafe); }
    .special-card-body { padding: 22px; }
    .special-kicker { color: #cc7a00; font-size: .78rem; font-weight: 800; letter-spacing: .08em; text-transform: uppercase; }
</style>

<section class="special-hero">
    <div class="special-kicker text-warning">BJDD SPECIAL PUBLICATIONS</div>
    <h1 class="mt-2 mb-2">Special Issues &amp; Conferences</h1>
    <p class="mb-2" style="max-width:720px;color:#e6edff;">Explore peer-reviewed special issues, conference-associated research publications, and thematic scholarly collections published through the BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD).</p>
    <p class="mb-0" style="color:#e6edff;">Published by <strong>EAGLE LEAP PUBLICATION</strong></p>
</section>

<div class="row g-4">
    @forelse($specialIssues as $specialIssue)
        <div class="col-md-6 col-xl-4">
            <article class="special-card">
                @if($specialIssue->cover_image)
                    <img class="special-card-cover" src="{{ asset('storage/' . ltrim($specialIssue->cover_image, '/')) }}" alt="{{ $specialIssue->title }} banner">
                @else
                    <div class="special-card-cover d-flex align-items-center justify-content-center text-center px-4"><span class="fw-bold text-primary">Special Issue</span></div>
                @endif
                <div class="special-card-body">
                    <h2 class="h4 mt-2">{{ $specialIssue->title }}</h2>
                    @if($specialIssue->subtitle)<p class="text-muted mb-2">{{ $specialIssue->subtitle }}</p>@endif
                    <p class="small mb-3"><strong>{{ $specialIssue->institution ?: 'BJDD Journal' }}</strong>@if($specialIssue->conference_date) · {{ $specialIssue->conference_date->format('d M Y') }}@endif</p>
                    <a class="btn btn-primary" href="{{ route('special-issues.show', $specialIssue) }}">View Special Issue <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </article>
        </div>
    @empty
        <div class="col-12"><div class="alert alert-light border text-center py-5">No special issues are currently available.</div></div>
    @endforelse
</div>

@if($specialIssues->hasPages())<div class="mt-4">{{ $specialIssues->links() }}</div>@endif
@endsection
