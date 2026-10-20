@php
    $submissionDate = optional($submission->submitted_at)->format('d F Y, h:i A')
        ?: now()->format('d F Y, h:i A');
    $specialIssue = $submission->specialIssue;
@endphp
Dear {{ $submission->author_main_name }},

Greetings from the BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD).

We wish to inform you that your submitted manuscript has entered the preliminary editorial screening stage.

MANUSCRIPT DETAILS
Manuscript ID: {{ $submission->paper_id }}
Title: {{ $submission->title }}
Special Issue: {{ $specialIssue?->title ?: 'Special Issue' }}
Current Status: Editorial Screening
Submission Date & Time: {{ $submissionDate }}

The editorial team is currently assessing your manuscript for its relevance to the journal's scope, formatting requirements, originality documentation, and submission guidelines.

You will be notified once the preliminary assessment is completed.

Thank you for your patience and cooperation.

Warm regards,
Editorial Office

BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD)
ISSN: 3139-1486 (Online) | ISSN: 3139-9819 (Print)
Website: https://bjddjournal.org
