@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 style="color:#00004d; font-weight:bold;">Publications Management</h4>
  <a href="{{ route('admin.publications.create') }}" 
     class="btn"
     style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">
     + Add New Publication
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
          <th>Title</th>
          <th>Author</th>
          <th>Volume/Issue</th>
          <th>Year</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($publications as $publication)
        <tr>
          <td>{{ $publication->paper_title }}</td>
          <td>{{ $publication->author_name }}</td>
          <td>Vol. {{ $publication->volume }}, Iss. {{ $publication->issue }}</td>
          <td>{{ $publication->year }}</td>
          <td>
            <a href="{{ route('admin.publications.edit', $publication->id) }}" 
               class="btn btn-sm" 
               style="background-color:#cc7a00; color:#fff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;">
               Edit
            </a>
            <form action="{{ route('admin.publications.destroy', $publication->id) }}" method="POST" style="display:inline;" class="delete-form">
              @csrf
              @method('DELETE')
              <button type="button" class="btn btn-sm delete-btn" 
                      style="background-color:#000000; color:#ffffff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;">
                Delete
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center" style="color:#cc7a00; font-weight:600;">
            No publications found
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@if($publications->hasPages())
<div class="mt-4">
  <nav aria-label="Publications pagination">
    <div class="d-flex justify-content-between align-items-center">
      <div class="text-muted small">
        Showing {{ $publications->firstItem() }} to {{ $publications->lastItem() }} of {{ $publications->total() }} results
      </div>
      <ul class="pagination pagination-sm mb-0">
        {{-- Previous Page Link --}}
        @if($publications->onFirstPage())
          <li class="page-item disabled">
            <span class="page-link" style="background-color:#f8f9fa; color:#6c757d; border-color:#dee2e6;">Previous</span>
          </li>
        @else
          <li class="page-item">
            <a class="page-link" href="{{ $publications->previousPageUrl() }}" 
               style="color:#00004d; border-color:#00004d;">Previous</a>
          </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach($publications->getUrlRange(1, $publications->lastPage()) as $page => $url)
          @if($page == $publications->currentPage())
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
        @if($publications->hasMorePages())
          <li class="page-item">
            <a class="page-link" href="{{ $publications->nextPageUrl() }}" 
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:10px;">
      <div class="modal-header" style="background-color:#00004d; color:#fff; border-radius:10px 10px 0 0;">
        <h5 class="modal-title" id="deleteConfirmLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color:#fff;"></button>
      </div>
      <div class="modal-body" style="color:#000;">
        Are you sure you want to delete?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" style="background-color:#6c757d; color:#fff; border-radius:6px;" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn" id="confirmDeleteBtn" style="background-color:#cc0000; color:#fff; border-radius:6px;">Delete</button>
      </div>
    </div>
  </div>
</div>

<script>
  let formToSubmit;
  document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function () {
      formToSubmit = this.closest('.delete-form');
      let deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
      deleteModal.show();
    });
  });

  document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    if (formToSubmit) {
      formToSubmit.submit();
    }
  });

  // Auto-dismiss success alert after 5 seconds
  document.addEventListener('DOMContentLoaded', function() {
    const alert = document.querySelector('.alert.alert-success');
    if (alert) {
      setTimeout(function() {
        alert.classList.remove('show');
        alert.classList.add('fade');
        setTimeout(() => alert.remove(), 500); // remove after fade effect
      }, 3000); // 5 seconds
    }
  });
</script>
@endsection