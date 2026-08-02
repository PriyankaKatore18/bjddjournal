@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f4f7fb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .policy-hero {
        background: linear-gradient(135deg, #0f172a, #1e3a8a);
        color: #fff;
        padding: 40px 30px;
        border-radius: 16px;
        margin-bottom: 25px;
        text-align: center;
    }

    .policy-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        transition: 0.3s;
    }

    .policy-card:hover {
        transform: translateY(-2px);
    }

    .policy-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 10px;
        border-left: 5px solid #f59e0b;
        padding-left: 10px;
    }

    .policy-text {
        color: #555;
        line-height: 1.7;
        font-size: 14.5px;
        margin: 0;
    }

    .accordion-button {
        font-weight: 600;
    }

    .accordion-button:not(.collapsed) {
        background: #e0f2fe;
        color: #0f172a;
    }
</style>

<div class="container py-4">

    <!-- HERO -->
    <div class="policy-hero">
        <h2 class="fw-bold">Journal Policies</h2>
        <p class="mb-0">
            BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD) maintains strong ethical publishing standards,
            transparency, and research integrity across all publications.
        </p>
    </div>

    <!-- ACCORDION START -->
    <div class="accordion" id="policyAccordion">

        <!-- 1 Editorial Policy -->
        <div class="policy-card">
            <div class="policy-title">1. Editorial Policy</div>
            <p class="policy-text">
                BJDD ensures independent, fair, and transparent editorial decisions.
                Manuscripts are evaluated based on originality, academic quality,
                methodological rigor, and ethical compliance. The Editor-in-Chief
                holds final decision authority. Confidentiality and conflict of
                interest policies are strictly maintained.
            </p>
        </div>

        <!-- 2 Peer Review -->
        <div class="policy-card">
            <div class="policy-title">2. Peer Review Policy</div>
            <p class="policy-text">
                BJDD follows a double-blind peer review system ensuring unbiased
                evaluation. Manuscripts are reviewed by experts based on originality,
                methodology, clarity, and contribution to research. Reviewer feedback
                guides editorial decisions.
            </p>
        </div>

        <!-- 3 Ethics -->
        <div class="policy-card">
            <div class="policy-title">3. Publication Ethics & Malpractice</div>
            <p class="policy-text">
                BJDD strictly prohibits plagiarism, data fabrication, duplicate
                publication, authorship misconduct, and unethical practices.
                Violations may lead to rejection, retraction, or institutional notification.
            </p>
        </div>

        <!-- 4 Plagiarism -->
        <div class="policy-card">
            <div class="policy-title">4. Plagiarism Policy</div>
            <p class="policy-text">
                All submissions must be original. Plagiarism, improper citation,
                self-plagiarism, or duplicate publication is strictly prohibited.
                Manuscripts are checked using plagiarism detection tools and editorial review.
            </p>
        </div>

        <!-- 5 AI -->
        <div class="policy-card">
            <div class="policy-title">5. AI Policy</div>
            <p class="policy-text">
                AI tools may be used only for language improvement and formatting.
                AI cannot generate data, results, or be listed as an author.
                Authors are fully responsible for all content accuracy and integrity.
            </p>
        </div>

        <!-- 6 Conflict -->
        <div class="policy-card">
            <div class="policy-title">6. Conflict of Interest Policy</div>
            <p class="policy-text">
                Authors, reviewers, and editors must disclose any financial,
                institutional, or personal conflicts that may influence research
                evaluation or publication decisions.
            </p>
        </div>

        <!-- 7 Copyright -->
        <div class="policy-card">
            <div class="policy-title">7. Copyright Policy</div>
            <p class="policy-text">
                Authors retain copyright while granting BJDD publishing rights.
                Proper permissions must be obtained for third-party content.
            </p>
        </div>

        <!-- 8 Open Access -->
        <div class="policy-card">
            <div class="policy-title">8. Open Access Policy</div>
            <p class="policy-text">
                BJDD provides free, unrestricted access to all published content
                without subscription or access barriers.
            </p>
        </div>

        <!-- 9 Licensing -->
        <div class="policy-card">
            <div class="policy-title">9. Licensing Policy</div>
            <p class="policy-text">
                Authors retain ownership while granting publication and distribution rights.
                Proper citation is required for reuse and redistribution.
            </p>
        </div>

        <!-- 10 Authorship -->
        <div class="policy-card">
            <div class="policy-title">10. Authorship Policy</div>
            <p class="policy-text">
                Only contributors with significant intellectual input may be listed as authors.
                Ghost, guest, or gift authorship is strictly prohibited.
            </p>
        </div>

        <!-- 11 Reviewer -->
        <div class="policy-card">
            <div class="policy-title">11. Reviewer Guidelines</div>
            <p class="policy-text">
                Reviewers must provide objective, timely, and confidential feedback.
                Conflicts of interest must be disclosed before accepting review.
            </p>
        </div>

        <!-- 12 Editor -->
        <div class="policy-card">
            <div class="policy-title">12. Editor Guidelines</div>
            <p class="policy-text">
                Editors ensure fair evaluation based on academic merit only.
                Confidentiality and ethical decision-making are strictly required.
            </p>
        </div>

        <!-- 13 Retraction -->
        <div class="policy-card">
            <div class="policy-title">13. Retraction Policy</div>
            <p class="policy-text">
                Articles may be retracted for plagiarism, errors, misconduct, or duplicate publication.
                Retraction notices remain linked to the original article.
            </p>
        </div>

        <!-- 14 Correction -->
        <div class="policy-card">
            <div class="policy-title">14. Correction & Errata Policy</div>
            <p class="policy-text">
                Minor errors are corrected via errata without affecting overall findings.
                Authors must notify the journal immediately if errors are found.
            </p>
        </div>

        <!-- 15 Withdrawal -->
        <div class="policy-card">
            <div class="policy-title">15. Withdrawal Policy</div>
            <p class="policy-text">
                Manuscripts may be withdrawn before or during review with valid reasons.
                Withdrawal after acceptance is strongly discouraged.
            </p>
        </div>

        <!-- 16 Privacy -->
        <div class="policy-card">
            <div class="policy-title">16. Privacy Policy</div>
            <p class="policy-text">
                BJDD protects all user data including author and reviewer information.
                Data is used only for publication-related processes.
            </p>
        </div>

        <!-- 17 Disclaimer -->
        <div class="policy-card">
            <div class="policy-title">17. Disclaimer</div>
            <p class="policy-text">
                Published content reflects authors' views only.
                BJDD is not responsible for accuracy or interpretations of research findings.
            </p>
        </div>

        <!-- 18 APC -->
        <div class="policy-card">
            <div class="policy-title">18. Article Processing Charges (APC)</div>
            <p class="policy-text">
                APC supports journal operations. Payment does not influence acceptance decisions.
                All manuscripts undergo independent peer review.
            </p>
        </div>

        <!-- 19 Archiving -->
        <div class="policy-card">
            <div class="policy-title">19. Archiving Policy</div>
            <p class="policy-text">
                Published articles are permanently archived for long-term accessibility
                through journal systems and repositories.
            </p>
        </div>

        <!-- 20 DOI -->
        <div class="policy-card">
            <div class="policy-title">20. DOI Policy</div>
            <p class="policy-text">
                BJDD assigns DOIs to published articles to ensure permanent identification,
                citation, and global discoverability.
            </p>
        </div>

    </div>

</div>

@endsection