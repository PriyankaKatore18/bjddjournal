@php
    $submissionDate = optional($submission->submitted_at)->format('d F Y, h:i A')
        ?: now()->format('d F Y, h:i A');
@endphp
Dear {{ $submission->author_main_name }},

Thank you for submitting your manuscript to the BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD).

This email confirms that your manuscript has been successfully received and registered with the Editorial Office.

SUBMISSION DETAILS
Paper ID: {{ $submission->paper_id }}
Manuscript Title: {{ $submission->title }}
Research Area: {{ $submission->research_area }}
Corresponding Author: {{ $submission->author_main_name }}
Submission Date & Time: {{ $submissionDate }}

Current Status: Submitted – Preliminary Editorial Screening

Your manuscript will now undergo preliminary editorial and integrity screening to assess its suitability for the journal, compliance with submission requirements, and adherence to applicable publication and research ethics standards.

Manuscripts that successfully complete the initial screening will proceed to further editorial assessment and, where appropriate, peer review.

Please retain your Paper ID: {{ $submission->paper_id }} and quote it in all future correspondence concerning this submission.

Important: This acknowledgement confirms receipt of the manuscript only and does not constitute acceptance for publication.

Thank you for considering the BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD) for the dissemination of your research.

Regards,
Editorial Office

BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE
ISSN: 3139-1486 (Online) | ISSN: 3139-9819 (Print)
An Open Access, Peer-Reviewed, Multidisciplinary Scholarly Journal
Bi-monthly | Multilingual | Academic Research
Published & Managed By: Eagle Leap Publication, Pune, Maharashtra, India
www.bjddjournal.org | +91 9890382132
