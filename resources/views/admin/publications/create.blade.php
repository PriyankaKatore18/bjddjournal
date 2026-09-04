@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-center">
	<div style="width:100%; max-width:1200px;">

		<h4 class="mb-4 text-center" style="color:#00004d; font-weight:600;">Add New Publication</h4>

		<form method="POST" action="{{ route('admin.publications.store') }}"
			style="background:#ffffff; padding:30px; border-radius:10px; box-shadow:0px 4px 12px rgba(0,0,0,0.15);"
			enctype="multipart/form-data">
			@csrf

			<div class="row mb-4">
				<div class="col-md-6">
					<div class="mb-3">
						<label class="form-label fw-semibold">Paper Title *</label>
						<input type="text" name="paper_title" class="form-control" required>
					</div>
				</div>
				<div class="col-md-6">
					<div class="mb-3">
						<label class="form-label fw-semibold">Author Name *</label>
						<input type="text" name="author_name" class="form-control" required>
					</div>
				</div>
			</div>

			<div class="row mb-4">
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label fw-semibold">Volume *</label>
						<input type="number" name="volume" class="form-control" value="{{ old('volume', $currentIssueDefaults['volume'] ?? '') }}" required>
					</div>
				</div>
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label fw-semibold">Issue *</label>
						<input type="number" name="issue" class="form-control" value="{{ old('issue', $currentIssueDefaults['issue'] ?? '') }}" required>
					</div>
				</div>
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label fw-semibold">Issue Range *</label>
						<input type="text" name="issue_range" class="form-control" value="{{ old('issue_range', $currentIssueDefaults['issue_range'] ?? '') }}" required>
					</div>
				</div>
			</div>

			<div class="row mb-4">
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label fw-semibold">Year *</label>
						<input type="number" name="year" class="form-control" value="{{ old('year', $currentIssueDefaults['year'] ?? '') }}" required>
					</div>
				</div>
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label fw-semibold">Registration ID *</label>
						<input type="text" name="registration_id" class="form-control" required>
					</div>
				</div>
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label fw-semibold">Published Paper ID *</label>
						<input type="text" name="published_paper_id" class="form-control" required>
					</div>
				</div>
			</div>

			<div class="row mb-4">
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label fw-semibold">eISSN</label>
						<input type="text" name="eissn" class="form-control" value="{{ old('eissn', $currentIssueDefaults['eissn'] ?? '') }}">
					</div>
				</div>
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label fw-semibold">Country</label>
						<input type="text" name="country" class="form-control">
					</div>
				</div>
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label fw-semibold"> DOI</label>
						<input type="text" name="crossref_doi" class="form-control">
					</div>
				</div>
			</div>

			<div class="row mb-4">
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label fw-semibold">Article Type</label>
						<input type="text" name="article_type" class="form-control" value="{{ old('article_type', 'Research Article') }}">
					</div>
				</div>
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label fw-semibold">Publication Type</label>
						<input type="text" name="publication_type" class="form-control" value="{{ old('publication_type', 'Peer Reviewed Journal') }}">
					</div>
				</div>
				<div class="col-md-4">
					<div class="mb-3">
						<label class="form-label fw-semibold">Publisher</label>
						<input type="text" name="publisher" class="form-control" value="{{ old('publisher', 'BODHIVRUKSHA Publication') }}">
					</div>
				</div>
			</div>

			<div class="row mb-4">
				<div class="col-md-6">
					<div class="mb-3">
						<label class="form-label fw-semibold">Frequency</label>
						<input type="text" name="frequency" class="form-control" value="{{ old('frequency', 'Bi-monthly') }}">
					</div>
				</div>
				<div class="col-md-6">
					<div class="mb-3">
						<label class="form-label fw-semibold">Language</label>
						<input type="text" name="language" class="form-control" value="{{ old('language', 'English') }}">
					</div>
				</div>
			</div>

			{{-- ADDED: Abstract Field --}}
			<div class="mb-4">
				<div class="mb-3">
					<label class="form-label fw-semibold">Abstract</label>
					<textarea name="abstract" class="form-control" rows="5"></textarea>
					<div class="form-text">Provide a concise summary of the paper.</div>
				</div>
			</div>

			<div class="row mb-4">
				<div class="col-md-3">
					<div class="mb-3">
						<label class="form-label fw-semibold">Received Date</label>
						<input type="date" name="received_at" class="form-control" value="{{ old('received_at') }}">
					</div>
				</div>
				<div class="col-md-3">
					<div class="mb-3">
						<label class="form-label fw-semibold">Revised Date</label>
						<input type="date" name="revised_at" class="form-control" value="{{ old('revised_at') }}">
					</div>
				</div>
				<div class="col-md-3">
					<div class="mb-3">
						<label class="form-label fw-semibold">Accepted Date</label>
						<input type="date" name="accepted_at" class="form-control" value="{{ old('accepted_at') }}">
					</div>
				</div>
				<div class="col-md-3">
					<div class="mb-3">
						<label class="form-label fw-semibold">Published Online</label>
						<input type="date" name="published_online_at" class="form-control" value="{{ old('published_online_at') }}">
					</div>
				</div>
			</div>

			<div class="mb-3">
				<label>Keywords</label>
				<textarea
					name="keywords"
					class="form-control"
					rows="3"
					placeholder="Keyword1, Keyword2, Keyword3">{{ old('keywords', $publication->keywords ?? '') }}</textarea>
			</div>
			
			{{-- END ADDED: Abstract Field --}}

			<div class="row mb-4">
				<div class="col-md-6">
					<div class="mb-3">
						<label class="form-label fw-semibold">Page Numbers</label>
						<input type="text" name="page_nos" class="form-control">
					</div>
				</div>
				<div class="col-md-6">
					<div class="mb-3">
						<label class="form-label fw-semibold">Paper URL</label>
						<input type="url" name="paper_url" class="form-control">
					</div>
				</div>
			</div>

			{{-- NEW ROW FOR FILE UPLOADS: PDF and CERTIFICATE --}}
			<div class="row mb-4">
				<div class="col-md-6">
					<div class="mb-3">
						<label class="form-label fw-semibold">Paper PDF File *</label>
						<input type="file" name="paper_pdf" class="form-control" accept=".pdf" required>
						<div class="form-text">Upload PDF file only (Max: 10MB)</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="mb-3">
						<label class="form-label fw-semibold">Certificate Image</label>
						<input type="file" name="certificate" class="form-control" accept="image/*">
						<div class="form-text">Optional: Upload certificate image (Max: 5MB)</div>
					</div>
				</div>
			</div>

			<div class="d-flex gap-2 justify-content-center">
				<button class="btn" style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Save Publication</button>
				<a href="{{ route('admin.publications.index') }}" class="btn" style="background-color:#cc7a00; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Cancel</a>
			</div>
		</form>

	</div>
</div>
@endsection
