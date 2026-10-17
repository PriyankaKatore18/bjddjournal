@extends('admin.layouts.app')

@section('title', 'Edit Published Article')
@section('page-title', 'Edit Published Article')

@section('content')
<div class="mb-4">
    <div class="text-muted small">{{ $specialIssue->special_issue_id }}</div>
    <h4 style="color:#00004d;font-weight:700;">Edit Published Article</h4>
    <p class="text-muted mb-0">{{ $article->article_title }}</p>
</div>
@include('admin.special-issues.articles._form')
@endsection
