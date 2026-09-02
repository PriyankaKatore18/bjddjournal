@extends('admin.layouts.app')

@section('title', 'Add Blog')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="d-flex justify-content-center">

    <div style="width:100%;max-width:800px;">

        <h4 class="mb-4 text-center"
            style="color:#00004d;font-weight:600;">
            Add Blog
        </h4>

        <form action="{{ route('admin.blogs.store') }}"
            method="POST"
            enctype="multipart/form-data"
            style="background:#fff;padding:25px;border-radius:10px;box-shadow:0px 4px 12px rgba(0,0,0,.15);">

            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Blog Image <span class="text-danger">*</span>
                </label>

                <input type="file"
                    name="image"
                    class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Description <span class="text-danger">*</span>
                </label>

                <textarea name="description"
                    rows="8"
                    class="form-control"
                    required></textarea>
            </div>

            <div class="d-flex gap-2 justify-content-center">

                <button class="btn"
                    style="background:#00004d;color:#fff;">
                    Save Blog
                </button>

                <a href="{{ route('admin.blogs.index') }}"
                    class="btn"
                    style="background:#cc7a00;color:#fff;">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection