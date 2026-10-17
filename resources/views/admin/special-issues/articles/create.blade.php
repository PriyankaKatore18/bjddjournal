@extends('admin.layouts.app')

@section('title', 'Add Published Article')
@section('page-title', 'Add Published Article')

@section('content')
<div class="mb-4">
    <div class="text-muted small">{{ $specialIssue->special_issue_id }}</div>
    <h4 style="color:#00004d;font-weight:700;">Add Published Article</h4>
    <p class="text-muted mb-0">{{ $specialIssue->title }}</p>
</div>
@include('admin.special-issues.articles._form')
@endsection
