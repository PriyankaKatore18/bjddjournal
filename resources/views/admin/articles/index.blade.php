@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 style="color:#00004d; font-weight:bold;">Articles</h4>
    <a href="{{ route('admin.articles.create') }}"
       class="btn"
       style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">
        + Add Article
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
                <p>Are you sure you want to delete this article?</p>
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
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->author->name }}</td>
                    <td>
                        @php
                            $statusColors = [
                                'submitted'    => 'background:#003300; color:white;',
                                'under_review' => 'background:#cc7a00; color:white;',
                                'accepted'     => 'background:#00004d; color:white;',
                                'rejected'     => 'background:#000000; color:white;',
                                'published'    => 'background:#00cc00; color:white;',
                            ];
                        @endphp
                        <span class="badge"
                              style="{{ $statusColors[$article->status] ?? 'background:#6c757d; color:white;' }} font-size:0.85rem; padding:6px 10px; border-radius:12px;">
                            {{ ucfirst(str_replace('_', ' ', $article->status)) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.articles.edit', $article) }}"
                           class="btn btn-sm"
                           style="background-color:#cc7a00; color:#fff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;">
                            Edit
                        </a>
                        <button class="btn btn-sm delete-btn"
                                style="background-color:#000000; color:#ffffff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;"
                                data-id="{{ $article->id }}"
                                data-action="{{ route('admin.articles.destroy', $article) }}">
                            Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center" style="color:#cc7a00; font-weight:600;">
                        No articles found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $articles->links() }}
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss success alert after 5 seconds
    const alert = document.querySelector('.alert.alert-success');
    if (alert) {
        setTimeout(function() {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 500); // remove from DOM after fade
        }, 3000); // <-- 5 seconds
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
