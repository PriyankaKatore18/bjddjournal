@php
    $specialIssue = $submission->specialIssue;
    $statusDate = optional($submission->updated_at)->format('d F Y');
    $statusLabels = ['editorial_screening' => 'Editorial Screening', 'revision_required' => 'Revision Required', 'under_review' => 'Under Review', 'accepted' => 'Accepted for Publication', 'rejected' => 'Rejected', 'payment_pending' => 'Payment Pending', 'published' => 'Published'];
    $statusLabel = $statusLabels[$submission->status] ?? ucfirst(str_replace('_', ' ', $submission->status));
@endphp
<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ $statusLabel }} | {{ $submission->paper_id }}</title></head>
<body style="margin:0;padding:0;background:#f3f6f5;color:#243238;font-family:Arial,Helvetica,sans-serif;line-height:1.6;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f3f6f5;"><tr><td align="center" style="padding:32px 16px;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:680px;background:#fff;border:1px solid #dce5e1;border-radius:8px;overflow:hidden;">
<tr><td style="padding:28px 32px;background:#064e3b;color:#fff;text-align:center;"><div style="font-size:22px;font-weight:700;">BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</div><div style="margin-top:8px;font-size:12px;">Manuscript Status Update</div></td></tr>
<tr><td style="padding:32px;">
<p style="margin:0 0 18px;">Dear {{ $submission->author_main_name }},</p>
<p style="margin:0 0 16px;">Greetings from the BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD).</p>
@switch($submission->status)
    @case('editorial_screening')<p>We wish to inform you that your submitted manuscript has entered the preliminary editorial screening stage.</p>@break
    @case('revision_required')<p>Following the editorial assessment of your manuscript, certain revisions are required before further consideration for publication.</p>@break
    @case('under_review')<p>We are pleased to inform you that your manuscript has completed the applicable preliminary editorial screening and has proceeded to the review stage.</p>@break
    @case('accepted')<p><strong>Congratulations!</strong> We are pleased to inform you that your research manuscript has been accepted for publication following the applicable editorial and review process.</p>@break
    @case('rejected')<p>Thank you for submitting your research manuscript to BJDD. Following editorial evaluation, we regret to inform you that your manuscript has not been accepted for publication.</p>@break
    @case('payment_pending')<p>Your manuscript has been accepted for publication. To proceed with publication, kindly complete the applicable publication fee payment.</p>@break
    @case('published')<p><strong>Congratulations on the publication of your research article!</strong> Your research manuscript has been successfully published in BJDD.</p>@break
@endswitch
<h2 style="margin:22px 0 12px;color:#064e3b;font-size:19px;">Manuscript Details</h2>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border:1px solid #dce5e1;border-radius:6px;overflow:hidden;">
<tr><td width="42%" style="padding:11px 14px;background:#f0f7f4;border-bottom:1px solid #dce5e1;"><strong>Manuscript ID</strong></td><td style="padding:11px 14px;border-bottom:1px solid #dce5e1;">{{ $submission->paper_id }}</td></tr>
<tr><td style="padding:11px 14px;background:#f0f7f4;border-bottom:1px solid #dce5e1;"><strong>Title</strong></td><td style="padding:11px 14px;border-bottom:1px solid #dce5e1;">{{ $submission->title }}</td></tr>
<tr><td style="padding:11px 14px;background:#f0f7f4;border-bottom:1px solid #dce5e1;"><strong>{{ $specialIssue ? 'Special Issue' : 'Submission Type' }}</strong></td><td style="padding:11px 14px;border-bottom:1px solid #dce5e1;">{{ $specialIssue?->title ?: 'Regular Journal Submission' }}</td></tr>
<tr><td style="padding:11px 14px;background:#f0f7f4;border-bottom:1px solid #dce5e1;"><strong>Current Status</strong></td><td style="padding:11px 14px;border-bottom:1px solid #dce5e1;">{{ $statusLabel }}</td></tr>
<tr><td style="padding:11px 14px;background:#f0f7f4;"><strong>Status Date</strong></td><td style="padding:11px 14px;">{{ $statusDate }}</td></tr>
</table>
@if(in_array($submission->status, ['revision_required', 'rejected'], true))
<h2 style="margin:22px 0 12px;color:#064e3b;font-size:19px;">Editorial Remarks</h2>
<p style="white-space:pre-line;margin:0;padding:13px 15px;background:#fff8e8;border-left:4px solid #c47d18;">{{ $submission->editorial_remarks ?: 'Please refer to the editorial communication for further details.' }}</p>
@endif
@if($submission->status === 'payment_pending')
<h2 style="margin:22px 0 12px;color:#064e3b;font-size:19px;">Publication Fee Details</h2>
<p style="margin:0 0 8px;"><strong>Amount Payable:</strong> {{ $submission->publication_fee !== null ? 'INR '.number_format((float) $submission->publication_fee, 2) : 'As communicated by the Editorial Office' }}</p>
@if($submission->payment_link)<p style="margin:0;"><strong>Payment Link:</strong> <a href="{{ $submission->payment_link }}">Complete Payment</a></p>@endif
<p style="margin:12px 0 0;">After completing the payment, kindly submit your payment receipt or transaction reference for verification.</p>
@endif
@if($submission->status === 'published' && $submission->article_url)
<h2 style="margin:22px 0 12px;color:#064e3b;font-size:19px;">Access Your Published Article</h2><p style="margin:0;"><a href="{{ $submission->article_url }}">{{ $submission->article_url }}</a></p>
@endif
@if($submission->status === 'editorial_screening')<p>The editorial team is currently assessing your manuscript for its relevance to the journal's scope, formatting requirements, originality documentation, and submission guidelines.</p><p>You will be notified once the preliminary assessment is completed.</p>@endif
@if($submission->status === 'under_review')<p>Your manuscript is currently being evaluated in accordance with the journal's editorial and peer-review procedures. The editorial decision will be communicated upon completion of the review process.</p>@endif
@if($submission->status === 'accepted')<p>Your manuscript will now proceed to the remaining publication formalities, including applicable fee verification, final formatting, and production.</p>@endif
@if($submission->status === 'rejected')<p>This decision has been made in accordance with the journal's editorial assessment and publication standards. We encourage you to continue your scholarly work.</p>@endif
@if($submission->status === 'payment_pending')<p>Further publication processing will continue after successful payment verification.</p>@endif
@if($submission->status === 'published')<p>You may now access, download, and share your published research article with the academic and research community.</p>@endif
<p style="margin:22px 0 0;">Warm regards,<br><strong>Editorial Office</strong></p>
</td></tr>
<tr><td style="padding:24px 32px;background:#172235;color:#fff;text-align:center;font-size:12px;"><div style="font-size:16px;font-weight:700;">BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</div><div style="margin-top:8px;">ISSN: 3139-1486 (Online) | ISSN: 3139-9819 (Print)</div><div style="margin-top:4px;">Website: <a href="https://bjddjournal.org" style="color:#fff;">https://bjddjournal.org</a></div></td></tr>
</table></td></tr></table>
</body></html>
