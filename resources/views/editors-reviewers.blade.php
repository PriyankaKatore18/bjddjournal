@extends('layouts.app')

@section('title', 'Editors & Reviewers - BJDD')

@section('content')
<div class="container my-4">

    <div class="publisher-section mt-5">
        <div class="container">
            <div class="row justify-content-center">
                @if(isset($chiefEditors) && $chiefEditors->count() > 0)
                @foreach($chiefEditors as $chiefEditor)
                <div class="col-md-8">
                    <div class="chief-editor-card text-white text-center">
                        <div class="card-body">
                            {{-- Photo field - Only display if exists --}}
                            @if(!empty($chiefEditor->photo))
                            <?php
                            // Extract just the filename from the path
                            $filename = basename($chiefEditor->photo);
                            ?>
                            <div class="mb-3">
                                <img src="{{ route('journal-team.photos', $filename) }}"
                                    alt="{{ $chiefEditor->name }}"
                                    class="img-fluid"
                                    style="width: 120px; height: 120px; object-fit: cover;border-radius: 8px;">
                            </div>
                            @endif

                            <h4 class="card-title">{{ $chiefEditor->name }}</h4>
                            <div class="role-badge d-inline-block mb-3">Chief Editor</div>
                            <p class="card-text">
                                <strong>{{ $chiefEditor->position }}</strong><br>
                                {{ $chiefEditor->department }}<br>
                                {{ $chiefEditor->institution }}<br>
                                <i class="bi bi-envelope"></i> {{ $chiefEditor->email }}
                                @if($chiefEditor->phone)
                                <br><i class="bi bi-telephone"></i> {{ $chiefEditor->phone }}
                                @endif

                                {{-- Link field - Only display if exists --}}
                                @if(!empty($chiefEditor->link))
                                <br>
                                <a href="{{ $chiefEditor->link }}" target="_blank" class="text-white" style="text-decoration: none;">
                                    <i class="bi bi-link-45deg"></i> View Profile
                                </a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12">
                    <p class="text-center text-white">No chief editor information available</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <br>

    <div class="editor-section">
        <div class="container">
            <h2 class="section-title text-center">Editorial Board Members</h2>
            <div class="row">
                @if(isset($editors) && $editors->count() > 0)
                @foreach($editors as $editor)
                <div class="col-12 mb-4">
                    <div class="card editor-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    {{-- Photo field - Only display if exists --}}
                                    @if(!empty($editor->photo))
                                    <?php
                                    // Extract just the filename from the path
                                    $filename = basename($editor->photo);
                                    ?>
                                    <img src="{{ route('journal-team.photos', $filename) }}"
                                        alt="{{ $editor->name }}"
                                        class="img-fluid me-3"
                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    @endif
                                    <h5 class="card-title mb-0">{{ $editor->name }}</h5>
                                </div>
                                <span class="role-badge">Editorial Board</span>
                            </div>
                            <p class="card-text">
                                <strong>{{ $editor->position }}</strong><br>
                                {{ $editor->department }}<br>
                                {{ $editor->institution }}<br>
                                <i class="bi bi-envelope"></i> {{ $editor->email }}

                                {{-- Link field - Only display if exists --}}
                                @if(!empty($editor->link))
                                <br>
                                <a href="{{ $editor->link }}" target="_blank" style="color: #2b265e; text-decoration: none;">
                                    <i class="bi bi-link-45deg"></i> View Profile
                                </a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12">
                    <p class="text-center">No editors information available</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="editor-section">
        <div class="container">
            <h2 class="section-title text-center">Reviewers</h2>
            <div class="row">
                @if(isset($reviewers) && $reviewers->count() > 0)
                @foreach($reviewers as $reviewer)
                <div class="col-12 mb-4">
                    <div class="card editor-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    {{-- Photo field - Only display if exists --}}
                                    @if(!empty($reviewer->photo))
                                    <?php
                                    // Extract just the filename from the path
                                    $filename = basename($reviewer->photo);
                                    ?>
                                    <img src="{{ route('journal-team.photos', $filename) }}"
                                        alt="{{ $reviewer->name }}"
                                        class="img-fluid rounded-circle me-3"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                    @endif
                                    <h5 class="card-title mb-0">{{ $reviewer->name }}</h5>
                                </div>
                                <span class="role-badge">Reviewer</span>
                            </div>
                            <p class="card-text">
                                <strong>{{ $reviewer->position }}</strong><br>
                                {{ $reviewer->department }}<br>
                                {{ $reviewer->institution }}<br>
                                <i class="bi bi-envelope"></i> {{ $reviewer->email }}

                                {{-- Link field - Only display if exists --}}
                                @if(!empty($reviewer->link))
                                <br>
                                <a href="{{ $reviewer->link }}" target="_blank" style="color: #2b265e; text-decoration: none;">
                                    <i class="bi bi-link-45deg"></i> View Profile
                                </a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12">
                    <p class="text-center">No reviewers information available</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .publisher-section {
        background-color: #2b265e;
        color: white;
        padding: 30px 0;
        border-radius: 5px;
    }

    .section-title {
        font-weight: bold;
        margin-bottom: 25px;
        border-bottom: 2px solid;
        padding-bottom: 10px;
        display: inline-block;
    }

    .chief-editor-card {
        border: none;
        background: transparent;
    }

    .editor-card {
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .role-badge {
        background-color: #2b265e;
        color: white;
        padding: 5px 15px;
        border-radius: 4px;
        font-weight: bold;
    }

    .editor-section {
        padding: 30px 0;
    }

    .publisher-section .section-title {
        border-bottom-color: white;
    }

    .editor-section .section-title {
        color: #2b265e;
        border-bottom-color: #2b265e;
    }
</style>
@endsection