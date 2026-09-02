@extends('admin.layouts.app')

@section('title', 'Issues')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 style="color:#00004d; font-weight:bold;">Issues</h4>
  <a href="{{ route('admin.issues.create') }}" 
     class="btn"
     style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">
     + Add Issue
  </a>
</div>

@if(session('success'))
  <div class="alert alert-success" style="background-color:#00cc00; color:#fff; border:none; border-radius:5px;">
    {{ session('success') }}
  </div>
@endif

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="position: fixed; top: 20%; left: 50%; transform: translateX(-50%);">
        <div class="modal-content" style="border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.3);">
            <div class="modal-header" style="background-color:#00004d; color:white; border-top-left-radius:12px; border-top-right-radius:12px;">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding:20px; font-size:1rem;">
                <p>Are you sure you want to delete this issue?</p>
            </div>
            <div class="modal-footer" style="border-top:1px solid #eee; padding:15px 20px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color:#6c757d; border:none; border-radius:6px; padding:8px 16px;">Cancel</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="background-color:#dc3545; border:none; border-radius:6px; padding:8px 16px;">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card" style="box-shadow:0 4px 12px rgba(0,0,0,0.3); border:none; border-radius:10px;">
  <div class="table-responsive">
    <table class="table table-hover mb-0" style="color:#000000; font-size: 0.9rem;">
      <thead style="background-color:#00004d; color:#ffffff;">
        <tr>
          
          <th>Title</th>
          <th>Volume</th>
          <th>Number</th>
          <th>Publish Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($issues as $issue)
        <tr>
          
          <td>{{ $issue->title }}</td>
          <td>
            <span class="badge" 
                  style="background-color:#003300; color:#ffffff; font-size:0.85rem; padding:6px 10px; border-radius:12px;">
              {{ $issue->volume }}
            </span>
          </td>
          <td>
            <span class="badge" 
                  style="background-color:#003300; color:#ffffff; font-size:0.85rem; padding:6px 10px; border-radius:12px;">
              {{ $issue->number }}
            </span>
          </td>
          <td>{{ \Carbon\Carbon::parse($issue->publish_date)->format('M d, Y') }}</td>
          <td>
            <a href="{{ route('admin.issues.edit',$issue) }}" 
               class="btn btn-sm" 
               style="background-color:#cc7a00; color:#fff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;">
               Edit
            </a>
            <button class="btn btn-sm delete-btn"
                    style="background-color:#000000; color:#ffffff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;"
                    data-action="{{ route('admin.issues.destroy',$issue) }}">
              Delete
            </button>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center" style="color:#cc7a00; font-weight:600;">
            No issues found
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@if($issues->hasPages())
<div class="mt-4">
  <nav aria-label="Issues pagination">
    <div class="d-flex justify-content-between align-items-center">
      <div class="text-muted small">
        Showing {{ $issues->firstItem() }} to {{ $issues->lastItem() }} of {{ $issues->total() }} results
      </div>
      <ul class="pagination pagination-sm mb-0">
        {{-- Previous Page Link --}}
        @if($issues->onFirstPage())
          <li class="page-item disabled">
            <span class="page-link" style="background-color:#f8f9fa; color:#6c757d; border-color:#dee2e6;">Previous</span>
          </li>
        @else
          <li class="page-item">
            <a class="page-link" href="{{ $issues->previousPageUrl() }}" 
               style="color:#00004d; border-color:#00004d;">Previous</a>
          </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach($issues->getUrlRange(1, $issues->lastPage()) as $page => $url)
          @if($page == $issues->currentPage())
            <li class="page-item active">
              <span class="page-link" style="background-color:#00004d; border-color:#00004d;">{{ $page }}</span>
            </li>
          @else
            <li class="page-item">
              <a class="page-link" href="{{ $url }}" 
                 style="color:#00004d; border-color:#00004d;">{{ $page }}</a>
            </li>
          @endif
        @endforeach

        {{-- Next Page Link --}}
        @if($issues->hasMorePages())
          <li class="page-item">
            <a class="page-link" href="{{ $issues->nextPageUrl() }}" 
               style="color:#00004d; border-color:#00004d;">Next</a>
          </li>
        @else
          <li class="page-item disabled">
            <span class="page-link" style="background-color:#f8f9fa; color:#6c757d; border-color:#dee2e6;">Next</span>
          </li>
        @endif
      </ul>
    </div>
  </nav>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation modal handling
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const action = this.getAttribute('data-action');
            deleteForm.setAttribute('action', action);
            
            // Show the modal
            const modal = new bootstrap.Modal(deleteModal);
            modal.show();
        });
    });

    // Auto-dismiss success alert after 3 seconds
    const alert = document.querySelector('.alert.alert-success');
    if (alert) {
        setTimeout(function() {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 500); // remove after fade effect
        }, 3000); // 3 seconds
    }
});
</script>
@endsection