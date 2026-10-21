@php
    $specialIssue = $submission->specialIssue;
    $statusDate = optional($submission->updated_at)->format('d F Y');
    $statusLabels = ['editorial_screening' => 'Editorial Screening', 'revision_required' => 'Revision Required', 'under_review' => 'Under Review', 'accepted' => 'Accepted for Publication', 'rejected' => 'Rejected', 'payment_pending' => 'Payment Pending', 'published' => 'Published'];
    $statusLabel = $statusLabels[$submission->status] ?? ucfirst(str_replace('_', ' ', $submission->status));
@endphp
Dear {{ $submission->author_main_name }},

Greetings from the BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD).

MANUSCRIPT DETAILS
Manuscript ID: {{ $submission->paper_id }}
Title: {{ $submission->title }}
{{ $specialIssue ? 'Special Issue' : 'Submission Type' }}: {{ $specialIssue?->title ?: 'Regular Journal Submission' }}
Current Status: {{ $statusLabel }}
Status Date: {{ $statusDate }}

@if($submission->status === 'editorial_screening')
Your submitted manuscript has entered the preliminary editorial screening stage.
The editorial team is assessing its relevance, formatting, originality documentation, and submission compliance.
@elseif($submission->status === 'revision_required')
Certain revisions are required before further consideration for publication.
Editorial Remarks:
{{ $submission->editorial_remarks ?: 'Please refer to the editorial communication for further details.' }}
@elseif($submission->status === 'under_review')
Your manuscript has proceeded to the review stage and is being evaluated under the journal's editorial and peer-review procedures.
@elseif($submission->status === 'accepted')
Congratulations! Your manuscript has been accepted for publication. It will proceed to the remaining publication formalities.
@elseif($submission->status === 'rejected')
Following editorial evaluation, your manuscript has not been accepted for publication.
Editorial Remarks:
{{ $submission->editorial_remarks ?: 'Please refer to the editorial communication for further details.' }}
@elseif($submission->status === 'payment_pending')
Your manuscript has been accepted for publication. Please complete the applicable publication fee payment.
Amount Payable: {{ $submission->publication_fee !== null ? 'INR '.number_format((float) $submission->publication_fee, 2) : 'As communicated by the Editorial Office' }}
@if($submission->payment_link)Payment Link: {{ $submission->payment_link }}@endif
After payment, submit your receipt or transaction reference for verification.
@elseif($submission->status === 'published')
Congratulations! Your research manuscript has been successfully published in BJDD.
@if($submission->article_url)Published Article: {{ $submission->article_url }}@endif
@endif

Warm regards,
Editorial Office

BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD)
ISSN: 3139-1486 (Online) | ISSN: 3139-9819 (Print)
Website: https://bjddjournal.org
