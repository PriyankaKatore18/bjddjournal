@component('mail::message')
# Manuscript Submission Acknowledgement

Dear {{ $submission->author_main_name }},

We confirm that BJDD has received your manuscript submission.

**Paper ID:** {{ $submission->paper_id }}  
**Manuscript Title:** {{ $submission->title }}  
**Corresponding Author:** {{ $submission->author_main_name }}  
**Area of Research:** {{ $submission->research_area }}  
**Submission Date & Time:** {{ optional($submission->submitted_at)->format('d M Y, h:i A') }}

Your submission will proceed to initial editorial screening. This acknowledgement confirms receipt only and does not constitute acceptance for publication.

Please keep the Paper ID for all future correspondence.

Regards,  
{{ config('app.name') }}
@endcomponent
