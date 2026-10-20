@php
    $submissionDate = optional($submission->submitted_at)->format('d F Y, h:i A')
        ?: now()->format('d F Y, h:i A');
    $specialIssue = $submission->specialIssue;
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manuscript Under Editorial Screening | {{ $submission->paper_id }}</title>
</head>
<body style="margin:0;padding:0;background:#f3f6f5;color:#243238;font-family:Arial,Helvetica,sans-serif;line-height:1.6;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f3f6f5;">
        <tr>
            <td align="center" style="padding:32px 16px;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:680px;background:#fff;border:1px solid #dce5e1;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td style="padding:28px 32px;background:#064e3b;color:#fff;text-align:center;">
                            <div style="font-size:22px;font-weight:700;">BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</div>
                            <div style="margin-top:8px;font-size:12px;">Special Issue Manuscript Update</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 18px;">Dear {{ $submission->author_main_name }},</p>
                            <p style="margin:0 0 16px;">Greetings from the BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD).</p>
                            <p style="margin:0 0 18px;">We wish to inform you that your submitted manuscript has entered the preliminary editorial screening stage.</p>

                            <h2 style="margin:0 0 12px;color:#064e3b;font-size:19px;">Manuscript Details</h2>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border:1px solid #dce5e1;border-radius:6px;overflow:hidden;">
                                <tr><td width="42%" style="padding:11px 14px;background:#f0f7f4;border-bottom:1px solid #dce5e1;"><strong>Manuscript ID</strong></td><td style="padding:11px 14px;border-bottom:1px solid #dce5e1;">{{ $submission->paper_id }}</td></tr>
                                <tr><td style="padding:11px 14px;background:#f0f7f4;border-bottom:1px solid #dce5e1;"><strong>Title</strong></td><td style="padding:11px 14px;border-bottom:1px solid #dce5e1;">{{ $submission->title }}</td></tr>
                                <tr><td style="padding:11px 14px;background:#f0f7f4;border-bottom:1px solid #dce5e1;"><strong>Special Issue</strong></td><td style="padding:11px 14px;border-bottom:1px solid #dce5e1;">{{ $specialIssue?->title ?: 'Special Issue' }}</td></tr>
                                <tr><td style="padding:11px 14px;background:#f0f7f4;border-bottom:1px solid #dce5e1;"><strong>Current Status</strong></td><td style="padding:11px 14px;border-bottom:1px solid #dce5e1;">Editorial Screening</td></tr>
                                <tr><td style="padding:11px 14px;background:#f0f7f4;"><strong>Submission Date &amp; Time</strong></td><td style="padding:11px 14px;">{{ $submissionDate }}</td></tr>
                            </table>

                            <p style="margin:22px 0 16px;padding:13px 15px;border-left:4px solid #0f766e;background:#ecfdf5;color:#064e3b;"><strong>Current Status:</strong> Editorial Screening</p>
                            <p style="margin:0 0 16px;">The editorial team is currently assessing your manuscript for its relevance to the journal's scope, formatting requirements, originality documentation, and submission guidelines.</p>
                            <p style="margin:0 0 16px;">You will be notified once the preliminary assessment is completed.</p>
                            <p style="margin:0 0 4px;">Thank you for your patience and cooperation.</p>
                            <p style="margin:18px 0 0;">Warm regards,<br><strong>Editorial Office</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 32px;background:#172235;color:#fff;text-align:center;font-size:12px;">
                            <div style="font-size:16px;font-weight:700;">BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</div>
                            <div style="margin-top:8px;">ISSN: 3139-1486 (Online) | ISSN: 3139-9819 (Print)</div>
                            <div style="margin-top:4px;">An Open Access, Peer-Reviewed, Multidisciplinary Scholarly Journal</div>
                            <div>Bi-monthly | Multilingual | Academic Research</div>
                            <div style="margin-top:8px;">Published &amp; Managed By: Eagle Leap Publication, Pune, Maharashtra, India</div>
                            <div style="margin-top:12px;"><a href="https://bjddjournal.org" style="color:#fff;">www.bjddjournal.org</a> | +91 9890382132</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
