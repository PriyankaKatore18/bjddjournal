@extends('admin.layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 style="color:#00004d; font-weight:bold;">Submissions</h4>
    <a href="{{ route('admin.submissions.create') }}"
       class="btn"
       style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">
        + Add Submission
    </a>
</div>

@if(session('success'))
    <div id="successAlert" class="alert alert-success" style="background-color:#00cc00; color:#fff; border:none; border-radius:5px;">
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
                <p>Are you sure you want to delete this submission?</p>
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
        <table class="table table-hover mb-0" style="color:#000000; font-size: 0.9rem; table-layout: fixed; width: 100%;">
            <thead style="background-color:#00004d; color:#ffffff;">
                <tr>
                    
                    <th style="width: 25%;">Title</th>
                    <th style="width: 15%;">Research Area</th>
                    <th style="width: 15%;">Main Author</th>
                    <th style="width: 15%;">Email</th>
                    <th style="width: 12%;">Submitted At</th>
                    <th style="width: 8%;">Status</th>
                    <th style="width: 10%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $submission)
                <tr>
                    
                    <td style="word-wrap: break-word;">{{ $submission->title }}</td>
                    <td style="word-wrap: break-word;">{{ $submission->research_area }}</td>
                    <td style="word-wrap: break-word;">{{ $submission->author_main_name }}</td>
                    <td style="word-wrap: break-word;">{{ $submission->author_main_email }}</td>
                    <td style="word-wrap: break-word;">
                        @if($submission->created_at)
                            {{ $submission->created_at->format('d M Y') }}<br>
                            <small class="text-muted">{{ $submission->created_at->format('h:i A') }}</small>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge"
                              style="background-color:#003300; color:#ffffff; font-size:0.85rem; padding:6px 10px; border-radius:12px; white-space: normal; text-align: center; display: inline-block; max-width: 100%;">
                            {{ ucfirst($submission->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.submissions.edit',$submission) }}"
                           class="btn btn-sm"
                           style="background-color:#cc7a00; color:#fff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem; margin-bottom: 4px;">
                            Edit
                        </a>
                        <button class="btn btn-sm delete-btn"
                                style="background-color:#000000; color:#ffffff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;"
                                data-action="{{ route('admin.submissions.destroy',$submission) }}">
                            Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center" style="color:#cc7a00; font-weight:600;">
                        No submissions found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($submissions->hasPages())
<div class="mt-4">
  <nav aria-label="Submissions pagination">
    <div class="d-flex justify-content-between align-items-center">
      <div class="text-muted small">
        Showing {{ $submissions->firstItem() }} to {{ $submissions->lastItem() }} of {{ $submissions->total() }} results
      </div>
      <ul class="pagination pagination-sm mb-0">
        {{-- Previous Page Link --}}
        @if($submissions->onFirstPage())
          <li class="page-item disabled">
            <span class="page-link" style="background-color:#f8f9fa; color:#6c757d; border-color:#dee2e6;">Previous</span>
          </li>
        @else
          <li class="page-item">
            <a class="page-link" href="{{ $submissions->previousPageUrl() }}" 
               style="color:#00004d; border-color:#00004d;">Previous</a>
          </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach($submissions->getUrlRange(1, $submissions->lastPage()) as $page => $url)
          @if($page == $submissions->currentPage())
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
        @if($submissions->hasMorePages())
          <li class="page-item">
            <a class="page-link" href="{{ $submissions->nextPageUrl() }}" 
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
    
    // Auto-dismiss success alert after 5 seconds
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(function() {
            const alert = new bootstrap.Alert(successAlert);
            alert.close();
        }, 3000); // 5000 milliseconds = 5 seconds
    }
});
</script>
@endsection
