@extends('admin.layouts.app')

@section('title', 'Index Partners')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 style="color:#00004d; font-weight:bold;">Index Partners</h4>

  <a href="{{ route('admin.index-partners.create') }}" class="btn"
    style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">
    + Add Partner
  </a>
</div>

@if(session('success'))
<div id="success-alert" class="alert alert-success"
  style="background-color:#00cc00; color:#fff; border:none; border-radius:5px;">
  {{ session('success') }}
</div>
@endif

<div class="card" style="box-shadow:0 4px 12px rgba(0,0,0,0.3); border:none; border-radius:10px;">
  <div class="table-responsive">
    <table class="table table-hover mb-0" style="color:#000000; font-size:0.9rem;">
      <thead style="background-color:#00004d; color:#ffffff;">
        <tr>
          <th>Icon</th>
          <th> Name </th>
          <th>URL</th>
          <th>Actions</th>
        </tr>
      </thead>

      <tbody>
        @forelse($partners as $partner)
        <tr>
          <td>
            @if($partner->icon)
            <img src="{{ asset('storage/app/public/' . $partner->icon) }}"
              alt="Partner Icon"
              style="width:60px; height:60px; object-fit:contain; border-radius:6px;">
            @else
            -
            @endif
          </td>

          <td>
            @if($partner->name)
            {{ $partner->name }}
            @else
            -
            @endif
          </td>

          <td>
            @if($partner->url)
            <a href="{{ $partner->url }}" target="_blank">{{ $partner->url }}</a>
            @else
            -
            @endif
          </td>

          <td>
            <a href="{{ route('admin.index-partners.edit', $partner->id) }}"
              class="btn btn-sm"
              style="background-color:#cc7a00; color:#fff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;">
              Edit
            </a>

            <a href="{{ route('admin.index-partners.delete', $partner->id) }}"
              class="btn btn-sm delete-btn"
              style="background-color:#000000; color:#ffffff; border:none; border-radius:6px; padding:4px 10px; font-size:0.85rem;">
              Delete
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="3" class="text-center" style="color:#cc7a00; font-weight:600;">
            No partners found
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {

    // Auto hide success message after 3 seconds
    let successAlert = document.getElementById("success-alert");
    if (successAlert) {
      setTimeout(function() {
        successAlert.style.display = "none";
      }, 3000);
    }

    document.querySelectorAll(".delete-btn").forEach(function(button) {
      button.addEventListener("click", function(e) {
        e.preventDefault();

        let deleteUrl = this.getAttribute("href");

        Swal.fire({
          title: "Are you sure?",
          text: "You want to delete this partner!",
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