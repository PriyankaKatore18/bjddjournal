@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4" style="color: #cc7a00;">Frequently Asked Questions</h1>

    <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button text-dark" style="background-color: #ffffff;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                   1. What is the focus and scope of BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body" style="background-color: #f8f9fa; color: #000000;">
                    BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE is a peer-reviewed, open-access, multidisciplinary journal. It publishes original research papers, review articles, case studies, and short communications across fields such as Arts, Commerce, Science, Social Sciences, Management, Education, and Technology.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed text-dark" style="background-color: #ffffff;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                     2. How often is the journal published?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body" style="background-color: #f8f9fa; color: #000000;">
                     BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE is published on bio-monthly basis.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed text-dark" style="background-color: #ffffff;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    3. Which languages are accepted for submission?
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body" style="background-color: #f8f9fa; color: #000000;">
                    The journal accepts papers in English and recognized Indian/regional languages such as Marathi and Hindi.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed text-dark" style="background-color: #ffffff;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                   4. What is the manuscript submission format?
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                <div class="accordion-body" style="background-color: #f8f9fa; color: #000000;">
                    Manuscripts should be submitted in .doc or .docx (MS Word) format. The recommended style is Times New Roman, 12-point font size, with 1.15 line spacing.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFive">
                <button class="accordion-button collapsed text-dark" style="background-color: #ffffff;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    5. What is the maximum word limit for submissions?
                </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                <div class="accordion-body" style="background-color: #f8f9fa; color: #000000;">
                    The preferred length is up to 3000–5000 including references, tables, and figures. Extended papers may be considered with editorial approval.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingSix">
                <button class="accordion-button collapsed text-dark" style="background-color: #ffffff;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                    6. How long does the review process take?
                </button>
            </h2>
            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                <div class="accordion-body" style="background-color: #f8f9fa; color: #000000;">
                    All submissions undergo desk screening followed by a double-blind peer review. Fast Review (2 Days) + Publication (1 Day after acceptance).
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingSeven">
                <button class="accordion-button collapsed text-dark" style="background-color: #ffffff;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                    7. Is there a publication fee?
                </button>
            </h2>
            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                <div class="accordion-body" style="background-color: #f8f9fa; color: #000000;">
                   Yes. The publication fee is ₹900 for Indian authors and $14 for international authors.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingEight">
                <button class="accordion-button collapsed text-dark" style="background-color: #ffffff;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                    8. Does BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE check for plagiarism?
                </button>
            </h2>
            <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                <div class="accordion-body" style="background-color: #f8f9fa; color: #000000;">
                    Yes. Every submission is checked using plagiarism detection software. A similarity index of up to 6% (excluding references and standard text) is acceptable.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingNine">
                <button class="accordion-button collapsed text-dark" style="background-color: #ffffff;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                    9. Does the journal provide an ISSN and DOI?
                </button>
            </h2>
            <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#faqAccordion">
                <div class="accordion-body" style="background-color: #f8f9fa; color: #000000;">
                    BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE has applied for an E-ISSN, and the number will be updated on the website once allotted. DOI assignment will also be provided once the service is active.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTen">
                <button class="accordion-button collapsed text-dark" style="background-color: #ffffff;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                  10. How can authors submit their papers?
                </button>
            </h2>
            <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#faqAccordion">
                <div class="accordion-body" style="background-color: #f8f9fa; color: #000000;">
                    Authors can submit their manuscripts through the online submission form available on the website under the “Submit Paper” section.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
