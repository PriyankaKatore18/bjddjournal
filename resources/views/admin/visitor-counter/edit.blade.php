@extends('admin.layouts.app')

@section('page-title', 'Visitor Counter')

@section('content')
<div class="d-flex justify-content-center">
    <div style="width:100%; max-width:720px;">
        <h4 class="mb-4 text-center" style="color:#00004d; font-weight:600;">Visitor Counter</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div style="background:#ffffff; padding:30px; border-radius:10px; box-shadow:0px 4px 12px rgba(0,0,0,0.15);">
            @if(! $available)
                <div class="alert alert-warning mb-0">Run the visitor counter migrations before changing this value.</div>
            @else
                <form method="POST" action="{{ route('admin.visitor-counter.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Total Visitors</label>
                            <input type="number" name="total_visits" class="form-control" min="0" step="1" required value="{{ old('total_visits', $counter->total_visits ?? 0) }}">
                            <div class="form-text">This number appears in the public footer and continues increasing with new visitors.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Today's Visitors</label>
                            <input type="text" class="form-control bg-light" readonly value="{{ \App\Models\VisitorCounter::formatIndian((int) ($counter->today_visits ?? 0)) }}">
                            <div class="form-text">This daily count is tracked automatically.</div>
                        </div>
                    </div>

                    <div class="text-muted small mb-3">
                        Count date: {{ optional($counter->visit_date)->format('d F Y') ?: now()->format('d F Y') }}
                    </div>

                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn" type="submit" style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Save Total Visitors</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn" style="background-color:#cc7a00; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Cancel</a>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
