@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-center">
	<div style="width:100%; max-width:750px;">

		<h4 class="mb-4 text-center" style="color:#00004d; font-weight:600;">Edit Publication</h4>

		<form method="POST" action="{{ route('admin.publications.update', $publication->id) }}"
			style="background:#ffffff; padding:25px; border-radius:10px; box-shadow:0px 4px 12px rgba(0,0,0,0.15);"
			enctype="multipart/form-data">
			@csrf
			@method('PUT')

			{{-- Paper Title --}}
			<div class="mb-3">
				<label class="form-label fw-semibold">Paper Title</label>
				<input type="text" name="paper_title" class="form-control" required value="{{ old('paper_title', $publication->paper_title) }}">
			</div>

			{{-- Author Name --}}
			<div class="mb-3">
				<label class="form-label fw-semibold">Author Name</label>
				<input type="text" name="author_name" class="form-control" required value="{{ old('author_name', $publication->author_name) }}">
			</div>

			<div class="row">
				{{-- Volume --}}
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Volume</label>
					<input type="number" name="volume" class="form-control" required value="{{ old('volume', $publication->volume) }}">
				</div>

				{{-- Issue --}}
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Issue</label>
					<input type="number" name="issue" class="form-control" required value="{{ old('issue', $publication->issue) }}">
				</div>

				{{-- Issue Range --}}
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Issue Range</label>
					<input type="text" name="issue_range" class="form-control" required value="{{ old('issue_range', $publication->issue_range) }}">
				</div>
			</div>

			<div class="row">
				{{-- Year --}}
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Year</label>
					<input type="number" name="year" class="form-control" required value="{{ old('year', $publication->year) }}">
				</div>

				{{-- Registration ID --}}
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Registration ID</label>
					<input type="text" name="registration_id" class="form-control" required value="{{ old('registration_id', $publication->registration_id) }}">
				</div>

				{{-- Published Paper ID --}}
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Published Paper ID</label>
					<input type="text" name="published_paper_id" class="form-control" required value="{{ old('published_paper_id', $publication->published_paper_id) }}">
				</div>
			</div>

			<div class="row">
				{{-- eISSN --}}
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">eISSN</label>
					<input type="text" name="eissn" class="form-control" value="{{ old('eissn', $publication->eissn) }}">
				</div>

				{{-- Country --}}
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Country</label>
					<input type="text" name="country" class="form-control" value="{{ old('country', $publication->country) }}">
				</div>

				{{-- CrossRef DOI --}}
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold"> DOI</label>
					<input type="text" name="crossref_doi" class="form-control" value="{{ old('crossref_doi', $publication->crossref_doi) }}">
				</div>
			</div>


			<div class="mb-3">
				<label class="form-label fw-semibold">Abstract</label>
				<textarea name="abstract" class="form-control" rows="5">{{ old('abstract', $publication->abstract) }}</textarea>
				<div class="form-text">Provide a concise summary of the paper.</div>
			</div>

			<div class="row">
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Article Type</label>
					<input type="text" name="article_type" class="form-control" value="{{ old('article_type', $publication->article_type ?: 'Research Article') }}">
				</div>
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Publication Type</label>
					<input type="text" name="publication_type" class="form-control" value="{{ old('publication_type', $publication->publication_type ?: 'Peer Reviewed Journal') }}">
				</div>
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Publisher</label>
					<input type="text" name="publisher" class="form-control" value="{{ old('publisher', $publication->publisher ?: 'BODHIVRUKSHA Publication') }}">
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Frequency</label>
					<input type="text" name="frequency" class="form-control" value="{{ old('frequency', $publication->frequency ?: 'Bi-monthly') }}">
				</div>
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Language</label>
					<input type="text" name="language" class="form-control" value="{{ old('language', $publication->language ?: 'English') }}">
				</div>
			</div>

			<div class="row">
				<div class="col-md-3 mb-3">
					<label class="form-label fw-semibold">Received Date</label>
					<input type="date" name="received_at" class="form-control" value="{{ old('received_at', optional($publication->received_at)->format('Y-m-d')) }}">
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label fw-semibold">Revised Date</label>
					<input type="date" name="revised_at" class="form-control" value="{{ old('revised_at', optional($publication->revised_at)->format('Y-m-d')) }}">
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label fw-semibold">Accepted Date</label>
					<input type="date" name="accepted_at" class="form-control" value="{{ old('accepted_at', optional($publication->accepted_at)->format('Y-m-d')) }}">
				</div>
				<div class="col-md-3 mb-3">
					<label class="form-label fw-semibold">Published Online</label>
					<input type="date" name="published_online_at" class="form-control" value="{{ old('published_online_at', optional($publication->published_online_at)->format('Y-m-d')) }}">
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


			<div class="row">
				{{-- Page Numbers --}}
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Page Numbers</label>
					<input type="text" name="page_nos" class="form-control" value="{{ old('page_nos', $publication->page_nos) }}">
				</div>

				{{-- Current Article Views --}}
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Current Article Views</label>
					<input type="text" class="form-control bg-light" value="{{ $publication->view_count ?? 0 }}" readonly>
					<div class="form-text">This count is updated automatically per visitor session.</div>
				</div>

				{{-- Current Download Count --}}
				<div class="col-md-4 mb-3">
					<label class="form-label fw-semibold">Current Download Count</label>
					<input type="text" class="form-control bg-light" value="{{ $publication->download_count }}" readonly>
					<div class="form-text">This count is updated automatically.</div>
				</div>
			</div>

			<div class="row">
				{{-- Paper URL --}}
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Paper URL</label>
					<input type="url" name="paper_url" class="form-control" value="{{ old('paper_url', $publication->paper_url) }}">
				</div>

				{{-- Paper PDF File --}}
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Paper PDF File</label>
					<input type="file" name="paper_pdf" class="form-control" accept=".pdf">
					<div class="form-text">Upload PDF file only (Max: 10MB)</div>
					@if($publication->paper_pdf)
					<div class="form-text">
						Current file:
						{{-- UPDATED: Use the new viewPdf route --}}
						<a href="{{ route('admin.publications.viewPdf', $publication->id) }}" target="_blank" style="color: #00004d;">
							View Current PDF
						</a>
					</div>
					@endif
				</div>
			</div>

			{{-- NEW ROW FOR CERTIFICATE IMAGE --}}
			<div class="row">
				<div class="col-md-6 mb-3">
					<label class="form-label fw-semibold">Certificate Image</label>
					<input type="file" name="certificate" class="form-control" accept="image/*">
					<div class="form-text">Optional: Upload a new certificate image (Max: 5MB).</div>
				</div>
				<div class="col-md-6 mb-3">
					@if($publication->certificate_path)
					<label class="form-label fw-semibold">Current Certificate</label>
					<div class="form-text pt-2">
						<a href="{{ asset('storage/' . $publication->certificate_path) }}" target="_blank" style="color: #00004d; font-weight: 600;">
							View Current Certificate
						</a>
					</div>
					<div class="form-text text-danger mt-2">Uploading a new file will replace the current one.</div>
					@else
					<label class="form-label fw-semibold">Current Certificate</label>
					<div class="form-text pt-2">No certificate uploaded.</div>
					@endif
				</div>
			</div>
			{{-- END NEW ROW --}}

			{{-- Buttons --}}
			<div class="d-flex gap-2 justify-content-center">
				<button class="btn" style="background-color:#00004d; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Update Publication</button>
				<a href="{{ route('admin.publications.index') }}" class="btn" style="background-color:#cc7a00; color:#fff; font-weight:600; border-radius:6px; padding:8px 14px; font-size:0.9rem;">Cancel</a>
			</div>
		</form>

	</div>
</div>
@endsection
