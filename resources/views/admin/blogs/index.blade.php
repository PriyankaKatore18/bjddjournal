@extends('admin.layouts.app')

@section('title', 'Blogs')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 style="color:#00004d;font-weight:bold;">Blogs</h4>

    <a href="{{ route('admin.blogs.create') }}"
        class="btn"
        style="background:#00004d;color:#fff;">
        + Add Blog
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card shadow border-0">
    <div class="table-responsive">
        <table class="table table-hover mb-0">

            <thead style="background:#00004d;color:#fff;">
                <tr>
                    <th width="100">Image</th>
                    <th>Description</th>
                    <th width="180">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($blogs as $blog)

                <tr>

                    <td>
                        @if($blog->image)
                        <img src="{{ asset('storage/app/public/'.$blog->image) }}"
                            width="70"
                            height="70"
                            style="object-fit:cover;border-radius:8px;">
                        @endif
                    </td>

                    <td>
                        {{ \Illuminate\Support\Str::limit(strip_tags($blog->description),100) }}
                    </td>

                    <td>

                        <a href="{{ route('admin.blogs.edit',$blog->id) }}"
                            class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <a href="{{ route('admin.blogs.destroy',$blog->id) }}"
                            class="btn btn-sm delete-btn"
                            style="background-color:#000000;color:#ffffff;border:none;border-radius:6px;padding:4px 10px;font-size:0.85rem;">
                            Delete
                        </a>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="3" class="text-center">
                        No Blogs Found
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered"
                style="position: fixed; top: 20%; left: 50%; transform: translateX(-50%);">
                <div class="modal-content"
                    style="border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.3);">

                    <div class="modal-header"
                        style="background-color:#00004d;color:white;border-top-left-radius:12px;border-top-right-radius:12px;">
                        <h5 class="modal-title">Confirm Delete</h5>

                        <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>Are you sure you want to delete this blog?</p>
                    </div>

                    <div class="modal-footer">

                        <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <form id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="btn btn-danger">
                                Delete
                            </button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $blogs->links() }}
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Auto hide success message
    let successAlert = document.querySelector(".alert-success");
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.display = "none";
        }, 3000);
    }

    document.querySelectorAll(".delete-btn").forEach(function(button) {

        button.addEventListener("click", function(e) {
            e.preventDefault();

            let deleteUrl = this.getAttribute("href");

            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete this blog!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00004d",
                cancelButtonColor: "#cc7a00",
                confirmButtonText: "Yes, Delete"
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }

            });
        });

    });

});
</script>
@endsection