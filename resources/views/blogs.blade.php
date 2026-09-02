@extends('layouts.app')

@section('content')

<style>
    .blog-section {
        max-width: 1200px;
        margin: 50px auto;
        padding: 0 15px;
    }

    .page-title {
        text-align: center;
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 40px;
        color: #00004d;
    }

    .blog-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
        display: flex;
        gap: 25px;
        align-items: flex-start;
    }

    .blog-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        flex-shrink: 0;
    }

    .blog-content {
        flex: 1;
    }

    .blog-description {
        color: #444;
        font-size: 15px;
        line-height: 1.9;
    }

    @media(max-width:768px) {

        .blog-card {
            flex-direction: column;
        }

        .blog-image {
            width: 100%;
            height: 220px;
        }

        .page-title {
            font-size: 28px;
        }
    }
</style>

<div class="blog-section">

    <h1 class="page-title">
        Blogs
    </h1>

    @forelse($blogs as $blog)

    <div class="blog-card">

        @if($blog->image)
        <img src="{{ asset('storage/app/public/'.$blog->image) }}"
            class="blog-image"
            alt="Blog Image">
        @endif

        <div class="blog-content">

            <div class="blog-description">
                {!! $blog->description !!}
            </div>

        </div>

    </div>

    @empty

    <div class="alert alert-warning text-center">
        No Blogs Found
    </div>

    @endforelse

    <div class="mt-4">
        {{ $blogs->links() }}
    </div>

</div>

@endsection