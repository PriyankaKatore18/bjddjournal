@extends('admin.layouts.app')

@section('content')
  <h4 class="mb-4 fw-bold">📊 Dashboard</h4>

<div class="row g-3">
  {{-- New Submissions --}}
  <div class="col-md-3">
    <div class="card shadow-lg border-0 rounded-3 hover-card">
      <div class="card-body text-center">
        <div class="icon-circle mb-3" style="background-color:#cc7a00; border-radius:50%; width:60px; height:60px; display:flex; align-items:center; justify-content:center; margin:0 auto;">
          <i class="bi bi-upload fs-4" style="color:#ffffff;"></i>
        </div>
        <div style="font-weight:600; color:#000000;">New Submissions</div>
        <div style="font-size:2.5rem; font-weight:bold; color:#00004d;">{{ $newSubmissions }}</div>
      </div>
    </div>
  </div>

  {{-- Under Review --}}
  <div class="col-md-3">
    <div class="card shadow-lg border-0 rounded-3 hover-card">
      <div class="card-body text-center">
        <div class="icon-circle mb-3" style="background-color:#00004d; border-radius:50%; width:60px; height:60px; display:flex; align-items:center; justify-content:center; margin:0 auto;">
          <i class="bi bi-hourglass-split fs-4" style="color:#ffffff;"></i>
        </div>
        <div style="font-weight:600; color:#000000;">Pending</div>
        <div style="font-size:2.5rem; font-weight:bold; color:#cc7a00;">{{ $underReview }}</div>
      </div>
    </div>
  </div>

  {{-- Accepted --}}
  <div class="col-md-3">
    <div class="card shadow-lg border-0 rounded-3 hover-card">
      <div class="card-body text-center">
        <div class="icon-circle mb-3" style="background-color:#00cc00; border-radius:50%; width:60px; height:60px; display:flex; align-items:center; justify-content:center; margin:0 auto;">
          <i class="bi bi-check-circle fs-4" style="color:#ffffff;"></i>
        </div>
        <div style="font-weight:600; color:#000000;">Accepted</div>
        <div style="font-size:2.5rem; font-weight:bold; color:#003300;">{{ $accepted }}</div>
      </div>
    </div>
  </div>

  {{-- Published --}}
  <div class="col-md-3">
    <div class="card shadow-lg border-0 rounded-3 hover-card">
      <div class="card-body text-center">
        <div class="icon-circle mb-3" style="background-color:#003300; border-radius:50%; width:60px; height:60px; display:flex; align-items:center; justify-content:center; margin:0 auto;">
          <i class="bi bi-journal-text fs-4" style="color:#ffffff;"></i>
        </div>
        <div style="font-weight:600; color:#000000;">Published</div>
        <div style="font-size:2.5rem; font-weight:bold; color:#00cc00;">{{ $published }}</div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('styles')
<style>
  .icon-circle {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin: 0 auto;
  }
  .hover-card {
    transition: all 0.3s ease-in-out;
  }
  .hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
  }
</style>
@endpush