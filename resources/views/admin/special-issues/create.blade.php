@extends('admin.layouts.app')

@section('title', 'Add Special Issue')
@section('page-title', 'Add Special Issue')

@section('content')
<div class="mb-4">
    <h4 style="color:#00004d;font-weight:700;">Add Special Issue</h4>
    <p class="text-muted mb-0">Create a conference issue before adding its offline-approved final articles.</p>
</div>
@include('admin.special-issues._form')
@endsection
