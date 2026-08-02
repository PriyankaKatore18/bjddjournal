@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 style="color:#00004d; font-weight:bold;">Reviewers</h4>
  <a href="{{ route('admin.reviewers.create') }}" 
     class="btn"
     style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">
     + Add Reviewer
  </a>
</div>

@if(session('success'))
  <div class="alert alert-success" style="background-color:#00cc00; color:#fff; border:none; border-radius:5px;">
    {{ session('success') }}
  </div>
@endif

<div class="card" style="box-shadow:0 4px 12px rgba(0,0,0,0.3); border:none; border-radius:10px;">
  <div class="table-responsive">
    <table class="table table-hover mb-0" style="color:#000000; font-size: 0.9rem;">
      <thead style="background-color:#00004d; color:#ffffff;">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Expertise</th>
          <th>Affiliation</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($reviewers as $reviewer)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $reviewer->name }}</td>
          <td>{{ $reviewer->email }}</td>
          <td>
            <span class="badge" 
                  style="background-color:#003300; color:#ffffff; font-size:0.85rem; padding:6px 10px; border-radius:12px;">
              {{ $reviewer->expertise }}
            </span>
          </td>
          <td>{{ $reviewer->affiliation }}</td>
          <td>
            <a href="{{ route('admin.reviewers.edit', $reviewer) }}" 
               class="btn btn-sm" 
               style="background-color:#cc7a00; color:#fff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;">
               Edit
            </a>
            <form action="{{ route('admin.reviewers.destroy', $reviewer) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm" 
                      style="background-color:#000000; color:#ffffff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;"
                      onclick="return confirm('Are you sure?')">
                Delete
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center" style="color:#cc7a00; font-weight:600;">
            No reviewers found
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">
  {{-- {{ $reviewers->links() }} --}}
</div>
@endsection