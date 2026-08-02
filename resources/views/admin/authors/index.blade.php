@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 style="color:#00004d; font-weight:bold;">Authors</h4>
  <a href="{{ route('admin.authors.create') }}" 
     class="btn"
     style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">
     + Add Author
  </a>
</div>

@if(session('success'))
  <div class="alert alert-success" style="background-color:#00cc00; color:#fff; border:none; border-radius:5px;">
    {{ session('success') }}
  </div>
@endif

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.3);">
      <div class="modal-header" style="background-color:#00004d; color:#fff; border-top-left-radius:10px; border-top-right-radius:10px;">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this author?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color:#6c757d; color:#fff; border-radius:6px;">Cancel</button>
        <form id="deleteForm" method="POST" action="">
          @csrf @method('DELETE')
          <button type="submit" class="btn btn-danger" style="background-color:#dc3545; color:#fff; border-radius:6px;">Delete</button>
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
          <th style="width: 5%;">ID</th>
          <th style="width: 15%;">Name</th>
          <th style="width: 20%;">Email</th>
          <th style="width: 30%;">Affiliation</th>
          <th style="width: 15%;">Phone</th>
          <th style="width: 15%;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($authors as $author)
        <tr>
          <td style="word-wrap: break-word;">{{ $author->id }}</td>
          <td style="word-wrap: break-word;">{{ $author->name }}</td>
          <td style="word-wrap: break-word;">{{ $author->email }}</td>
          <td style="word-wrap: break-word;">
            <span class="badge" 
                  style="background-color:#003300; color:#ffffff; font-size:0.85rem; padding:6px 10px; border-radius:12px; white-space: normal; text-align: left; display: inline-block; max-width: 100%;">
              {{ $author->affiliation }}
            </span>
          </td>
          <td style="word-wrap: break-word;">{{ $author->phone }}</td>
          <td>
            <a href="{{ route('admin.authors.edit',$author) }}" 
               class="btn btn-sm" 
               style="background-color:#cc7a00; color:#fff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem; margin-bottom: 4px;">
               Edit
            </a>
            <button class="btn btn-sm delete-btn" 
                    style="background-color:#000000; color:#ffffff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;"
                    data-id="{{ $author->id }}"
                    data-action="{{ route('admin.authors.destroy',$author) }}">
              Delete
            </button>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center" style="color:#cc7a00; font-weight:600;">
            No authors found
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">
  {{ $authors->links() }}
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Handle delete button clicks
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const deleteForm = document.getElementById('deleteForm');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    
    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {
        const action = this.getAttribute('data-action');
        deleteForm.action = action;
        deleteModal.show();
      });
    });
  });
</script>
@endsection