@extends('admin.layouts.app')

@section('title', 'Journal Team Management')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 style="color:#00004d; font-weight:bold;">Journal Team Management</h4>
        <a href="{{ route('admin.journal-team.create') }}" 
           class="btn"
           style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">
           + Add New Member
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" style="background-color:#00cc00; color:#fff; border:none; border-radius:5px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.3);">
                <div class="modal-header" style="background-color:#00004d; color:white; border-top-left-radius:12px; border-top-right-radius:12px;">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding:20px; font-size:1rem;">
                    <p>Are you sure you want to delete this team member?</p>
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
    
    <!-- Chief Editors Section -->
    <div class="mb-5">
        <h4 class="mb-3 border-bottom pb-2" style="color:#00004d;">Chief Editors</h4>
        <div class="card" style="box-shadow:0 4px 12px rgba(0,0,0,0.3); border:none; border-radius:10px;">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="color:#000000; font-size: 0.9rem;">
                    <thead style="background-color:#00004d; color:#ffffff;">
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($chiefEditors as $index => $member)
                        <tr>
                            <td>
                                @if($member->hasPhoto())
                                    <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                @else
                                    <div style="width: 50px; height: 50px; background-color: #f0f0f0; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person" style="font-size: 1.5rem; color: #999;"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->position }}</td>
                            <td>
                                @if($member->hasLink())
                                    <a href="{{ $member->link }}" target="_blank" style="color: #00004d; text-decoration: none;">
                                        <i class="bi bi-link-45deg"></i> View Profile
                                    </a>
                                @else
                                    <span class="text-muted">No link</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge" style="background-color: {{ $member->is_active ? '#00cc00' : '#cc0000' }}; color:#ffffff; font-size:0.85rem; padding:6px 10px; border-radius:12px;">
                                    {{ $member->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $member->order }}</td>
                            <td>
                                <a href="{{ route('admin.journal-team.edit', $member->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#cc7a00; color:#fff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;">
                                   Edit
                                </a>
                                <button class="btn btn-sm delete-btn"
                                        style="background-color:#000000; color:#ffffff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;"
                                        data-action="{{ route('admin.journal-team.destroy', $member->id) }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($chiefEditors->hasPages())
        <div class="mt-4">
          <nav aria-label="Chief editors pagination">
            <div class="d-flex justify-content-between align-items-center">
              <div class="text-muted small">
                Showing {{ $chiefEditors->firstItem() }} to {{ $chiefEditors->lastItem() }} of {{ $chiefEditors->total() }} results
              </div>
              <ul class="pagination pagination-sm mb-0">
                {{-- Previous Page Link --}}
                @if($chiefEditors->onFirstPage())
                  <li class="page-item disabled">
                    <span class="page-link" style="background-color:#f8f9fa; color:#6c757d; border-color:#dee2e6;">Previous</span>
                  </li>
                @else
                  <li class="page-item">
                    <a class="page-link" href="{{ $chiefEditors->previousPageUrl() }}" 
                       style="color:#00004d; border-color:#00004d;">Previous</a>
                  </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach($chiefEditors->getUrlRange(1, $chiefEditors->lastPage()) as $page => $url)
                  @if($page == $chiefEditors->currentPage())
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
                @if($chiefEditors->hasMorePages())
                  <li class="page-item">
                    <a class="page-link" href="{{ $chiefEditors->nextPageUrl() }}" 
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
    </div>
    
    <!-- Editors Section -->
    <div class="mb-5">
        <h4 class="mb-3 border-bottom pb-2" style="color:#00004d;">Editors</h4>
        <div class="card" style="box-shadow:0 4px 12px rgba(0,0,0,0.3); border:none; border-radius:10px;">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="color:#000000; font-size: 0.9rem;">
                    <thead style="background-color:#00004d; color:#ffffff;">
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($editors as $index => $member)
                        <tr>
                            <td>
                                @if($member->hasPhoto())
                                    <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                @else
                                    <div style="width: 50px; height: 50px; background-color: #f0f0f0; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person" style="font-size: 1.5rem; color: #999;"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->position }}</td>
                            <td>
                                @if($member->hasLink())
                                    <a href="{{ $member->link }}" target="_blank" style="color: #00004d; text-decoration: none;">
                                        <i class="bi bi-link-45deg"></i> View Profile
                                    </a>
                                @else
                                    <span class="text-muted">No link</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge" style="background-color: {{ $member->is_active ? '#00cc00' : '#cc0000' }}; color:#ffffff; font-size:0.85rem; padding:6px 10px; border-radius:12px;">
                                    {{ $member->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $member->order }}</td>
                            <td>
                                <a href="{{ route('admin.journal-team.edit', $member->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#cc7a00; color:#fff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;">
                                   Edit
                                </a>
                                <button class="btn btn-sm delete-btn"
                                        style="background-color:#000000; color:#ffffff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;"
                                        data-action="{{ route('admin.journal-team.destroy', $member->id) }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($editors->hasPages())
        <div class="mt-4">
          <nav aria-label="Editors pagination">
            <div class="d-flex justify-content-between align-items-center">
              <div class="text-muted small">
                Showing {{ $editors->firstItem() }} to {{ $editors->lastItem() }} of {{ $editors->total() }} results
              </div>
              <ul class="pagination pagination-sm mb-0">
                {{-- Previous Page Link --}}
                @if($editors->onFirstPage())
                  <li class="page-item disabled">
                    <span class="page-link" style="background-color:#f8f9fa; color:#6c757d; border-color:#dee2e6;">Previous</span>
                  </li>
                @else
                  <li class="page-item">
                    <a class="page-link" href="{{ $editors->previousPageUrl() }}" 
                       style="color:#00004d; border-color:#00004d;">Previous</a>
                  </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach($editors->getUrlRange(1, $editors->lastPage()) as $page => $url)
                  @if($page == $editors->currentPage())
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
                @if($editors->hasMorePages())
                  <li class="page-item">
                    <a class="page-link" href="{{ $editors->nextPageUrl() }}" 
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
    </div>
    
    <!-- Reviewers Section -->
    <div class="mb-5">
        <h4 class="mb-3 border-bottom pb-2" style="color:#00004d;">Reviewers</h4>
        <div class="card" style="box-shadow:0 4px 12px rgba(0,0,0,0.3); border:none; border-radius:10px;">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="color:#000000; font-size: 0.9rem;">
                    <thead style="background-color:#00004d; color:#ffffff;">
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviewers as $index => $member)
                        <tr>
                            <td>
                                @if($member->hasPhoto())
                                    <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                @else
                                    <div style="width: 50px; height: 50px; background-color: #f0f0f0; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person" style="font-size: 1.5rem; color: #999;"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->position }}</td>
                            <td>
                                @if($member->hasLink())
                                    <a href="{{ $member->link }}" target="_blank" style="color: #00004d; text-decoration: none;">
                                        <i class="bi bi-link-45deg"></i> View Profile
                                    </a>
                                @else
                                    <span class="text-muted">No link</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge" style="background-color: {{ $member->is_active ? '#00cc00' : '#cc0000' }}; color:#ffffff; font-size:0.85rem; padding:6px 10px; border-radius:12px;">
                                    {{ $member->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $member->order }}</td>
                            <td>
                                <a href="{{ route('admin.journal-team.edit', $member->id) }}" 
                                   class="btn btn-sm" 
                                   style="background-color:#cc7a00; color:#fff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;">
                                   Edit
                                </a>
                                <button class="btn btn-sm delete-btn"
                                        style="background-color:#000000; color:#ffffff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;"
                                        data-action="{{ route('admin.journal-team.destroy', $member->id) }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($reviewers->hasPages())
        <div class="mt-4">
          <nav aria-label="Reviewers pagination">
            <div class="d-flex justify-content-between align-items-center">
              <div class="text-muted small">
                Showing {{ $reviewers->firstItem() }} to {{ $reviewers->lastItem() }} of {{ $reviewers->total() }} results
              </div>
              <ul class="pagination pagination-sm mb-0">
                {{-- Previous Page Link --}}
                @if($reviewers->onFirstPage())
                  <li class="page-item disabled">
                    <span class="page-link" style="background-color:#f8f9fa; color:#6c757d; border-color:#dee2e6;">Previous</span>
                  </li>
                @else
                  <li class="page-item">
                    <a class="page-link" href="{{ $reviewers->previousPageUrl() }}" 
                       style="color:#00004d; border-color:#00004d;">Previous</a>
                  </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach($reviewers->getUrlRange(1, $reviewers->lastPage()) as $page => $url)
                  @if($page == $reviewers->currentPage())
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
                @if($reviewers->hasMorePages())
                  <li class="page-item">
                    <a class="page-link" href="{{ $reviewers->nextPageUrl() }}" 
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
    </div>
</div>

<script>
// Auto-dismiss success alert after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alert = document.querySelector('.alert.alert-success');
    if (alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    }
    
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
});
</script>
@endsection