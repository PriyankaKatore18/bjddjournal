@php
    $submissionDate = optional($submission->submitted_at)->format('d F Y, h:i A')
        ?: now()->format('d F Y, h:i A');
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manuscript Submission Acknowledgement – {{ $submission->paper_id }}</title>
</head>
<body style="margin:0; padding:0; background:#f3f6f5; color:#243238; font-family:Arial, Helvetica, sans-serif; line-height:1.6;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f3f6f5;">
        <tr>
            <td align="center" style="padding:32px 16px;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:680px; background:#ffffff; border:1px solid #dce5e1; border-radius:8px; overflow:hidden;">
                    <tr>
                        <td style="padding:28px 32px; background:#064e3b; color:#ffffff; text-align:center;">
                            <div style="font-size:22px; font-weight:700; letter-spacing:.2px;">BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</div>
                            <div style="margin-top:8px; font-size:12px;">Manuscript Submission Acknowledgement</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 18px;">Dear {{ $submission->author_main_name }},</p>

                            <p style="margin:0 0 16px;">Thank you for submitting your manuscript to the BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD).</p>
                            <p style="margin:0 0 24px;">This email confirms that your manuscript has been successfully received and registered with the Editorial Office.</p>

                            <h2 style="margin:0 0 12px; color:#064e3b; font-size:19px;">Submission Details</h2>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border:1px solid #dce5e1; border-radius:6px; overflow:hidden;">
                                <tr>
                                    <td width="42%" style="padding:11px 14px; background:#f0f7f4; border-bottom:1px solid #dce5e1;"><strong>Paper ID</strong></td>
                                    <td style="padding:11px 14px; border-bottom:1px solid #dce5e1;">{{ $submission->paper_id }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:11px 14px; background:#f0f7f4; border-bottom:1px solid #dce5e1;"><strong>Manuscript Title</strong></td>
                                    <td style="padding:11px 14px; border-bottom:1px solid #dce5e1;">{{ $submission->title }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:11px 14px; background:#f0f7f4; border-bottom:1px solid #dce5e1;"><strong>Research Area</strong></td>
                                    <td style="padding:11px 14px; border-bottom:1px solid #dce5e1;">{{ $submission->research_area }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:11px 14px; background:#f0f7f4; border-bottom:1px solid #dce5e1;"><strong>Corresponding Author</strong></td>
                                    <td style="padding:11px 14px; border-bottom:1px solid #dce5e1;">{{ $submission->author_main_name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:11px 14px; background:#f0f7f4;"><strong>Submission Date &amp; Time</strong></td>
                                    <td style="padding:11px 14px;">{{ $submissionDate }}</td>
                                </tr>
                            </table>

                            <p style="margin:22px 0 16px; padding:13px 15px; border-left:4px solid #0f766e; background:#ecfdf5; color:#064e3b;"><strong>Current Status:</strong> Submitted – Preliminary Editorial Screening</p>

                            <p style="margin:0 0 16px;">Your manuscript will now undergo preliminary editorial and integrity screening to assess its suitability for the journal, compliance with submission requirements, and adherence to applicable publication and research ethics standards.</p>
                            <p style="margin:0 0 16px;">Manuscripts that successfully complete the initial screening will proceed to further editorial assessment and, where appropriate, peer review.</p>
                            <p style="margin:0 0 16px;"><strong>Please retain your Paper ID: {{ $submission->paper_id }}</strong> and quote it in all future correspondence concerning this submission.</p>
                            <p style="margin:0 0 24px;"><strong>Important:</strong> This acknowledgement confirms receipt of the manuscript only and does not constitute acceptance for publication.</p>

                            <p style="margin:0 0 4px;">Thank you for considering the BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD) for the dissemination of your research.</p>
                            <p style="margin:0;">Regards,<br><strong>Editorial Office</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 32px; background:#172235; color:#ffffff; text-align:center; font-size:12px;">
                            <div style="font-size:16px; font-weight:700;">BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</div>
                            <div style="margin-top:8px;">ISSN: 3139-1486 (Online) | ISSN: 3139-9819 (Print)</div>
                            <div style="margin-top:4px;">An Open Access, Peer-Reviewed, Multidisciplinary Scholarly Journal</div>
                            <div>Bi-monthly | Multilingual | Academic Research</div>
                            <div style="margin-top:8px;">Published &amp; Managed By: Eagle Leap Publication, Pune, Maharashtra, India</div>
                            <div style="margin-top:12px;"><a href="https://www.bjddjournal.org" style="color:#ffffff;">www.bjddjournal.org</a> | +91 9890382132</div>
                            <div style="margin-top:12px;">
                                <a href="https://www.facebook.com/profile.php?id=61581012112879" style="color:#ffffff;">Facebook</a> |
                                <a href="https://www.instagram.com/bjdd_journal/" style="color:#ffffff;">Instagram</a> |
                                <a href="https://whatsapp.com/channel/0029Vb6IASSDZ4LZurhPte04" style="color:#ffffff;">WhatsApp Channel</a> |
                                <a href="https://chat.whatsapp.com/KBeW5fB7m8mIEgt23aCNb9" style="color:#ffffff;">WhatsApp Community</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
