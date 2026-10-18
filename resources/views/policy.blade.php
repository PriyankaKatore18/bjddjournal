@extends('layouts.app')

@section('content')
<style>
    body { background: #f4f7fb; }
    .policy-page { max-width: 1080px; margin: 0 auto; padding: 28px 18px 50px; }
    .policy-hero { background: linear-gradient(135deg, #0f172a, #1e3a8a); color: #fff; padding: 40px 30px; border-radius: 16px; margin-bottom: 25px; text-align: center; }
    .policy-hero h1 { margin: 0 0 10px; font-size: 2rem; }
    .policy-hero p { max-width: 820px; margin: 0 auto; line-height: 1.65; color: #e5edff; }
    .policy-card { background: #fff; border: 1px solid #dbe3ef; border-radius: 12px; margin-bottom: 12px; box-shadow: 0 5px 18px rgba(15, 23, 42, .05); overflow: hidden; }
    .policy-card summary { list-style: none; cursor: pointer; padding: 18px 22px; color: #1e3a8a; font-size: 1.05rem; font-weight: 700; border-left: 5px solid #f59e0b; display: flex; align-items: center; justify-content: space-between; gap: 15px; }
    .policy-card summary::-webkit-details-marker { display: none; }
    .policy-card summary::after { content: '+'; color: #f59e0b; font-size: 1.5rem; line-height: 1; }
    .policy-card[open] summary { background: #e0f2fe; color: #0f172a; }
    .policy-card[open] summary::after { content: '−'; }
    .policy-content { padding: 0 26px 22px; color: #4b5563; line-height: 1.7; font-size: .95rem; }
    .policy-content p { margin: 16px 0 0; }
    .policy-content h3 { margin: 20px 0 6px; color: #1e3a8a; font-size: 1rem; }
    .policy-content ul { margin: 10px 0 0 20px; padding: 0; }
    .policy-content li { margin: 4px 0; }
</style>

<main class="policy-page">
    <section class="policy-hero">
        <h1>Journal Policies</h1>
        <p>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD) maintains strong ethical publishing standards, transparency, and research integrity across all publications.</p>
    </section>

    <details class="policy-card">
        <summary>1. Editorial Policy</summary>
        <div class="policy-content">
            <p>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD) is committed to maintaining the highest standards of academic quality, research integrity, transparency, and ethical publishing. The journal follows a fair, independent, and rigorous editorial process to ensure that all published content contributes meaningfully to scholarly knowledge and academic advancement.</p>
            <p>The Editorial Board is responsible for overseeing the journal's publication activities and ensuring that manuscripts are evaluated solely on the basis of academic merit, originality, relevance, methodological rigor, and ethical compliance.</p>
            <h3>Editorial Independence</h3><p>All editorial decisions are made independently and without influence from authors, institutions, sponsors, advertisers, or external organizations. The Editor-in-Chief and Editorial Board retain full authority over manuscript evaluation, acceptance, revision, rejection, correction, and retraction decisions.</p>
            <h3>Scope and Relevance</h3><p>BJDD publishes original research articles, review papers, case studies, conceptual papers, and scholarly contributions from a wide range of disciplines. Manuscripts must align with the journal's aims and scope and demonstrate academic significance and originality.</p>
            <h3>Initial Editorial Assessment</h3><p>Every submitted manuscript undergoes an initial editorial screening to evaluate:</p><ul><li>Relevance to the journal's scope.</li><li>Originality and scholarly contribution.</li><li>Quality of presentation and language.</li><li>Research methodology and academic rigor.</li><li>Compliance with ethical standards.</li><li>Adherence to author guidelines.</li></ul><p>Manuscripts that do not meet the journal's basic requirements may be rejected without external review or returned for revision.</p>
            <h3>Editorial Decision-Making</h3><p>Editorial decisions are based on academic quality and originality, reviewer recommendations, methodological soundness, ethical compliance, and relevance and contribution to the field.</p><p>Possible editorial decisions include:</p><ul><li>Accept</li><li>Accept with Minor Revisions</li><li>Major Revisions Required</li><li>Resubmit for Review</li><li>Reject</li></ul><p>The final decision regarding publication rests with the Editor-in-Chief and Editorial Board.</p>
            <h3>Confidentiality</h3><p>All manuscripts and related communications are treated as confidential. Editors and editorial staff shall not disclose unpublished content or use information obtained during the editorial process for personal or professional advantage.</p>
            <h3>Conflict of Interest</h3><p>Editors must disclose any actual or potential conflicts of interest and recuse themselves from handling manuscripts where impartiality may be compromised.</p>
            <h3>Publication Ethics</h3><p>BJDD adheres to internationally recognized publication ethics standards and does not tolerate plagiarism, data fabrication, falsification, duplicate publication, authorship misconduct, citation manipulation, or peer-review manipulation.</p>
            <h3>Commitment to Excellence</h3><p>The Editorial Board continuously reviews editorial practices to ensure transparency, fairness, and quality in scholarly publishing. BJDD remains committed to fostering academic excellence, research integrity, and the global dissemination of knowledge.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>2. Peer Review Policy</summary>
        <div class="policy-content">
            <p>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD) follows a rigorous peer-review process to ensure the quality, credibility, originality, and scholarly value of all published research. Peer review is an essential component of academic publishing and helps maintain the integrity of the scientific and scholarly record.</p>
            <h3>Peer Review Model</h3><p>BJDD follows a Double-Blind Peer Review System, in which:</p><ul><li>Authors do not know the identity of reviewers.</li><li>Reviewers do not know the identity of authors.</li></ul><p>This process promotes fairness, objectivity, and unbiased evaluation of manuscripts.</p>
            <h3>Initial Editorial Screening</h3><p>Before peer review, manuscripts undergo editorial screening to assess scope and relevance, originality and significance, compliance with author guidelines, ethical standards, and plagiarism and similarity concerns. Only manuscripts meeting the journal's requirements proceed to peer review.</p>
            <h3>Reviewer Selection</h3><p>Reviewers are selected based on subject expertise, academic qualifications, research and publication experience, and absence of conflicts of interest. Typically, each manuscript is reviewed by at least two independent reviewers.</p>
            <h3>Review Criteria</h3><p>Reviewers evaluate manuscripts based on:</p><ul><li>Originality and innovation.</li><li>Relevance to the field.</li><li>Research design and methodology.</li><li>Data analysis and interpretation.</li><li>Literature review and references.</li><li>Clarity of presentation.</li><li>Validity of conclusions.</li><li>Ethical compliance.</li></ul>
            <h3>Reviewer Recommendations</h3><p>Reviewers may recommend Accept without Revision, Accept with Minor Revisions, Major Revisions Required, Resubmit for Further Review, or Reject. Reviewer recommendations are advisory, and the final publication decision remains with the Editorial Board.</p>
            <h3>Responsibilities of Reviewers</h3><p>Reviewers are expected to maintain confidentiality, provide objective and constructive feedback, complete reviews within the specified timeframe, disclose conflicts of interest, and report suspected plagiarism, ethical concerns, or research misconduct.</p>
            <h3>Responsibilities of Authors</h3><p>Authors are expected to cooperate throughout the review process, respond to reviewer comments professionally, submit revisions within the specified timeframe, and maintain ethical standards and research integrity.</p>
            <h3>Final Decision</h3><p>Following peer review and editorial evaluation, the Editor-in-Chief may accept, reject, or request further revisions to a manuscript. All decisions are based on academic merit, reviewer feedback, and compliance with journal standards.</p>
            <h3>Commitment to Quality</h3><p>BJDD considers peer review a cornerstone of scholarly publishing and is committed to maintaining a transparent, fair, and rigorous review process that supports high-quality academic research and responsible scholarly communication.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>3. Publication Ethics &amp; Malpractice Statement</summary>
        <div class="policy-content">
            <p>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD) is committed to maintaining the highest standards of publication ethics, research integrity, transparency, and academic excellence. The journal expects authors, reviewers, editors, and publishers to adhere to ethical publishing practices throughout the submission, review, and publication process.</p>
            <h3>Ethical Responsibilities</h3><p><strong>Authors:</strong> Authors must submit original work, properly acknowledge all sources, avoid plagiarism, data fabrication, falsification, duplicate publication, authorship misconduct, and disclose any conflicts of interest. All listed authors must have made significant contributions to the research and approve the final manuscript.</p><p><strong>Editors:</strong> Editors evaluate manuscripts fairly and solely on academic merit, originality, and relevance to the journal's scope. Editorial decisions are made independently and confidentially, without discrimination or conflicts of interest.</p><p><strong>Reviewers:</strong> Reviewers must provide objective, constructive, and confidential evaluations. They should disclose any conflicts of interest and report suspected ethical concerns, plagiarism, or research misconduct.</p>
            <h3>Research Misconduct</h3><p>The journal considers the following practices unethical:</p><ul><li>Plagiarism</li><li>Data fabrication or falsification</li><li>Duplicate or redundant publication</li><li>Authorship misconduct</li><li>Citation manipulation</li><li>Peer-review manipulation</li><li>Undisclosed conflicts of interest</li></ul>
            <h3>Handling Ethical Violations</h3><p>Any allegation of misconduct will be investigated by the Editorial Board. Depending on the severity of the case, the journal may request corrections or clarifications, reject the manuscript, suspend the review process, publish corrections or expressions of concern, retract published articles, or notify relevant institutions when necessary.</p>
            <h3>Corrections and Retractions</h3><p>BJDD reserves the right to issue corrections, retractions, or expressions of concern when significant errors, ethical breaches, or unreliable findings are identified.</p>
            <h3>Commitment to Ethical Publishing</h3><p>BJDD is dedicated to promoting responsible research, ethical scholarly communication, and the integrity of the academic record. The journal follows internationally accepted principles of publication ethics and reserves the right to update this policy as required.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>4. Plagiarism Policy</summary>
        <div class="policy-content">
            <p>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD) is committed to maintaining the highest standards of academic integrity, originality, and ethical publishing. The journal considers plagiarism a serious violation of publication ethics and does not tolerate any form of academic misconduct.</p><p>All manuscripts submitted to BJDD must be original works of the author(s) and must not contain plagiarized content, fabricated data, or improperly cited material.</p>
            <h3>Definition of Plagiarism</h3><p>Plagiarism refers to the use of another person's ideas, words, data, images, research findings, or intellectual work without proper acknowledgment or citation and presenting them as one's own work.</p><p>The journal considers the following as plagiarism:</p><ul><li>Direct copying of text without citation.</li><li>Improper paraphrasing of published work.</li><li>Use of another author's ideas without acknowledgment.</li><li>Self-plagiarism or excessive reuse of previously published content.</li><li>Unauthorized use of figures, tables, images, or research data.</li><li>Duplicate or redundant publication.</li></ul>
            <h3>Similarity Screening</h3><p>All submitted manuscripts may be screened using plagiarism detection software and editorial review before being sent for peer review.</p><p>The journal evaluates not only the similarity percentage but also the nature, source, and context of the overlapping content. Editorial judgment remains the primary basis for determining whether plagiarism has occurred.</p>
            <h3>Author Responsibilities</h3><p>Authors are responsible for submitting original and unpublished work, properly citing all sources and references, obtaining permissions for copyrighted materials where necessary, ensuring the accuracy and authenticity of their research, and disclosing any overlap with previously published or submitted work.</p><p>Submission of a manuscript to BJDD implies that all authors accept responsibility for the originality of the content.</p>
            <h3>Actions in Cases of Plagiarism</h3><p>If plagiarism is detected before publication, the journal may request corrections or revisions, return the manuscript to the author, reject the manuscript, or suspend the review process pending clarification.</p><p>If plagiarism is identified after publication, the journal may publish a correction notice, issue an expression of concern, retract the article, or notify the author's affiliated institution when necessary.</p>
            <h3>Academic Integrity</h3><p>BJDD follows a zero-tolerance approach toward plagiarism and is dedicated to promoting ethical research practices, responsible authorship, and scholarly integrity. The journal reserves the right to investigate suspected cases of plagiarism and take appropriate action to protect the integrity of the scholarly record.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>5. AI Policy</summary>
        <div class="policy-content">
            <p>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD) recognizes the growing use of Artificial Intelligence (AI) tools in academic research and scholarly writing. While AI technologies can support research, language improvement, and content organization, authors remain fully responsible for the accuracy, originality, integrity, and ethical standards of their submitted work.</p>
            <h3>Acceptable Use of AI</h3><p>Authors may use AI-assisted tools for:</p><ul><li>Language editing and grammar improvement.</li><li>Improving readability and formatting.</li><li>Literature organization and research assistance.</li><li>Data visualization and analytical support.</li></ul><p>Any use of AI tools must be disclosed appropriately in the manuscript where relevant.</p>
            <h3>Unacceptable Use of AI</h3><p>AI tools must not be used to generate fabricated data, results, or references; create misleading, false, or manipulated research findings; replace human intellectual contribution and critical analysis; produce content that violates publication ethics; or conceal the actual authorship of a manuscript.</p>
            <h3>Authorship and Accountability</h3><p>Artificial Intelligence tools, chatbots, or automated systems cannot be listed as authors or co-authors of a manuscript. Authorship is limited to individuals who have made substantial intellectual contributions and can take responsibility for the content.</p><p>Authors are solely responsible for the accuracy of all information presented, verification of facts, citations, and references, originality of the manuscript, and compliance with academic and ethical standards.</p>
            <h3>Editorial Use of AI</h3><p>BJDD editors and reviewers may use AI-assisted tools for administrative support, language assessment, plagiarism screening, and workflow management. However, all editorial decisions, peer-review evaluations, and publication judgments are made solely by qualified human editors and reviewers.</p>
            <h3>Policy Compliance</h3><p>Failure to disclose inappropriate AI use or misuse of AI technologies may result in manuscript rejection, publication correction, retraction, or other actions deemed necessary by the Editorial Board.</p>
            <h3>Commitment to Responsible AI Use</h3><p>BJDD supports the responsible, transparent, and ethical use of Artificial Intelligence in scholarly communication while maintaining the principles of academic integrity, human accountability, originality, and research excellence.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>6. Conflict of Interest Policy</summary>
        <div class="policy-content">
            <p>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD) is committed to maintaining transparency, objectivity, and integrity throughout the publication process. A conflict of interest exists when professional, financial, institutional, personal, or other relationships could influence, or appear to influence, the judgment, actions, or decisions of authors, reviewers, or editors.</p><p>The journal requires all participants involved in the publication process to disclose any actual, potential, or perceived conflicts of interest that may affect the evaluation, interpretation, or publication of scholarly work.</p>
            <h3>Author Responsibilities</h3><p>Authors must disclose all sources of financial support, funding, sponsorship, affiliations, employment relationships, consultancies, stock ownership, honoraria, patents, or personal relationships that may influence their research findings or interpretations.</p><p>Any potential conflict of interest should be clearly stated during manuscript submission. If no conflicts exist, authors are encouraged to include a statement indicating that they have no competing interests to declare.</p>
            <h3>Reviewer Responsibilities</h3><p>Reviewers must disclose any conflicts that may compromise their ability to provide an objective evaluation. Such conflicts may arise from professional collaborations, institutional affiliations, personal relationships, financial interests, or direct competition with the authors.</p><p>Reviewers who identify a conflict of interest should decline the review invitation and notify the Editorial Office promptly.</p>
            <h3>Editor Responsibilities</h3><p>Editors must recuse themselves from handling manuscripts where conflicts of interest exist. Editorial decisions must be based solely on scholarly merit, originality, academic quality, and relevance to the journal's scope.</p><p>Where a conflict is identified, an alternative editor shall be assigned to ensure a fair and unbiased review process.</p>
            <h3>Policy Enforcement</h3><p>Failure to disclose relevant conflicts of interest may result in manuscript rejection, publication correction, retraction, or other appropriate actions determined by the Editorial Board.</p><p>BJDD is committed to promoting transparency and maintaining the trust of the scholarly community through responsible conflict-of-interest management.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>7. Copyright Policy</summary>
        <div class="policy-content">
            <p>BJDD respects intellectual property rights and is committed to protecting the copyright interests of authors while ensuring the dissemination of scholarly knowledge.</p><p>Authors retain the copyright of their published work. By submitting and publishing their manuscript in BJDD, authors grant the journal a non-exclusive right to publish, reproduce, distribute, archive, and promote the article in electronic and other formats.</p><p>Authors are responsible for ensuring that submitted manuscripts do not infringe upon any copyright, intellectual property rights, or proprietary rights of third parties. Any content reproduced from other sources, including figures, tables, illustrations, photographs, or substantial textual extracts, must be accompanied by appropriate permissions and acknowledgments.</p><p>The journal reserves the right to publish accepted articles on its website, digital repositories, indexing platforms, and partner databases. Authors may share, distribute, and archive their published articles provided proper citation to the original publication in BJDD is maintained.</p><p>Any copyright disputes arising from published content remain the responsibility of the author(s). The journal shall not be held liable for unauthorized use of copyrighted material submitted by contributors.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>8. Open Access Policy</summary>
        <div class="policy-content">
            <p>BJDD is a fully open-access journal dedicated to promoting the unrestricted dissemination of scholarly research and academic knowledge.</p><p>All articles published in BJDD are made freely available online immediately upon publication without subscription fees, registration requirements, or access restrictions. Readers may access, read, download, print, share, and cite published articles without charge for lawful academic, educational, and research purposes.</p><p>The journal believes that open access enhances the visibility, accessibility, and impact of scholarly work while supporting global knowledge exchange and academic collaboration.</p><p>BJDD does not impose barriers that limit access to research findings. Through its open-access publishing model, the journal aims to contribute to equitable access to knowledge regardless of geographic, institutional, or economic circumstances.</p><p>The journal encourages researchers, educators, students, policymakers, and professionals worldwide to benefit from the research published in its pages.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>9. Licensing Policy</summary>
        <div class="policy-content">
            <p>BJDD supports responsible sharing and dissemination of scholarly content through appropriate licensing practices.</p><p>Authors retain copyright ownership of their published work while granting the journal the right to publish, archive, distribute, and preserve the article as part of the scholarly record.</p><p>Users may access and use published content for academic, educational, research, and non-commercial purposes, provided appropriate credit is given to the original authors and the journal.</p><p>Any reproduction, adaptation, translation, redistribution, or reuse of published material must include proper citation and acknowledgment of the original source.</p><p>The journal reserves the right to update licensing terms as required to align with evolving scholarly publishing standards and legal requirements. Authors are encouraged to familiarize themselves with the journal's licensing framework before submission.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>10. Authorship Policy</summary>
        <div class="policy-content">
            <p>BJDD recognizes authorship as an important indicator of responsibility, accountability, and scholarly contribution.</p><p>Authorship should be limited to individuals who have made substantial intellectual contributions to the research and manuscript preparation. Such contributions may include research conception and design, data collection, analysis and interpretation, drafting or critically revising the manuscript, and approval of the final version for publication.</p><p>All listed authors must have participated sufficiently in the work to take public responsibility for its content.</p><p>The corresponding author is responsible for ensuring that all eligible contributors are included as authors and that no inappropriate individuals are listed.</p><p>The journal does not permit:</p><ul><li>Guest Authorship</li><li>Gift Authorship</li><li>Ghost Authorship</li><li>Misrepresentation of Contributions</li></ul><p>Any changes to authorship after submission, including addition, removal, or reordering of authors, must be approved by all authors and justified in writing to the Editorial Office.</p><p>In cases of authorship disputes, the journal may suspend the editorial process until the matter is resolved by the involved parties or their institutions.</p><p>BJDD promotes transparency in author contributions and reserves the right to request clarification regarding individual contributions whenever necessary.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>11. Reviewer Guidelines</summary>
        <div class="policy-content">
            <p>The peer-review process is a fundamental component of scholarly publishing and plays a vital role in maintaining the quality, credibility, and integrity of academic research. BJDD relies on qualified reviewers to provide objective, constructive, and timely evaluations of submitted manuscripts.</p>
            <h3>Responsibilities of Reviewers</h3><p>Reviewers are expected to assess manuscripts based on:</p><ul><li>Originality and novelty of the research.</li><li>Academic and scientific merit.</li><li>Relevance to the journal's scope.</li><li>Soundness of methodology and analysis.</li><li>Clarity of presentation and organization.</li><li>Validity of conclusions.</li><li>Compliance with ethical standards.</li></ul>
            <h3>Confidentiality</h3><p>All manuscripts received for review must be treated as confidential documents. Reviewers shall not share, distribute, discuss, or use any unpublished information for personal, academic, or professional benefit.</p>
            <h3>Objectivity and Constructive Feedback</h3><p>Reviews should be fair, impartial, evidence-based, and respectful. Personal criticism of authors is inappropriate. Reviewers should provide clear recommendations and constructive suggestions that assist authors in improving their work.</p>
            <h3>Conflict of Interest</h3><p>Reviewers must disclose any actual or potential conflicts of interest arising from personal relationships, institutional affiliations, financial interests, or academic competition. Individuals with conflicts should decline the review invitation.</p>
            <h3>Timeliness</h3><p>Reviewers are expected to complete reviews within the specified timeframe. If unable to meet the deadline, they should inform the Editorial Office promptly.</p>
            <h3>Ethical Concerns</h3><p>Reviewers should notify editors if they identify possible plagiarism, duplicate publication, data manipulation, unethical research practices, or other forms of publication misconduct.</p><p>By accepting a review assignment, reviewers agree to uphold the highest standards of professionalism, confidentiality, and academic integrity.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>12. Editor Guidelines</summary>
        <div class="policy-content">
            <p>Editors play a central role in maintaining the quality, credibility, and ethical standards of BJDD. Editorial decisions must be guided by fairness, transparency, academic merit, and research integrity.</p>
            <h3>Editorial Responsibilities</h3><p>Editors are responsible for managing the peer-review process, ensuring timely manuscript evaluation, maintaining publication quality, upholding ethical publishing standards, and protecting the integrity of the scholarly record.</p>
            <h3>Editorial Decision-Making</h3><p>Manuscripts should be evaluated solely on originality and significance, academic quality and rigor, relevance to the journal's scope, methodological soundness, and contribution to existing knowledge.</p><p>Editorial decisions must not be influenced by the author's nationality, gender, ethnicity, religion, institutional affiliation, or political beliefs.</p>
            <h3>Confidentiality</h3><p>Editors must maintain strict confidentiality regarding manuscripts, reviewer reports, editorial discussions, and author information.</p>
            <h3>Conflict of Interest</h3><p>Editors shall recuse themselves from handling manuscripts in which they have personal, professional, financial, or institutional conflicts of interest.</p>
            <h3>Publication Ethics</h3><p>Editors are responsible for investigating allegations of plagiarism, duplicate publication, research misconduct, authorship disputes, and ethical concerns. Appropriate actions may include rejection, correction, retraction, or notification of relevant institutions.</p><p>BJDD expects editors to uphold the highest standards of objectivity, integrity, and professional conduct.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>13. Retraction Policy</summary>
        <div class="policy-content">
            <p>BJDD is committed to preserving the integrity and reliability of the scholarly record. Retraction serves as a mechanism for correcting the literature and alerting readers to publications containing significant errors or ethical violations.</p>
            <h3>Grounds for Retraction</h3><p>An article may be retracted if:</p><ul><li>Plagiarism is identified.</li><li>Data fabrication or falsification is discovered.</li><li>Significant errors invalidate the findings.</li><li>Duplicate or redundant publication is detected.</li><li>Research misconduct is confirmed.</li><li>Ethical approval requirements were not met.</li><li>Authorship fraud or serious publication malpractice occurs.</li></ul>
            <h3>Retraction Process</h3><p>The Editorial Board will conduct a fair and objective investigation before any retraction decision is made. Authors may be invited to provide explanations or supporting documentation during the investigation.</p>
            <h3>Retraction Notice</h3><p>When an article is retracted, a formal retraction notice will be published and linked to the original article. The notice will clearly state the reasons for retraction while maintaining transparency and accountability.</p>
            <h3>Preservation of Scholarly Record</h3><p>Retracted articles will generally remain accessible within the journal archive but will be clearly marked as retracted to maintain the integrity of the academic record.</p><p>BJDD reserves the right to retract articles whenever necessary to protect research integrity and public trust.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>14. Correction &amp; Errata Policy</summary>
        <div class="policy-content">
            <p>BJDD is committed to ensuring the accuracy, reliability, and integrity of published scholarly content. Despite rigorous editorial and peer-review processes, errors may occasionally be identified after publication.</p>
            <h3>Corrections</h3><p>Corrections may be issued when errors are identified that affect the accuracy, clarity, or completeness of an article but do not invalidate its overall findings.</p><p>Examples include author information errors, affiliation inaccuracies, reference mistakes, formatting issues, and minor factual inaccuracies.</p>
            <h3>Errata</h3><p>An erratum may be published when an error originates during the editorial, production, or publication process.</p>
            <h3>Author Responsibilities</h3><p>Authors are encouraged to notify the Editorial Office promptly if they discover errors in their published work.</p>
            <h3>Editorial Review</h3><p>The Editorial Board will evaluate reported concerns and determine the appropriate corrective action. Published corrections and errata will be clearly linked to the original article to ensure transparency.</p><p>BJDD is committed to maintaining an accurate and trustworthy scholarly record through timely correction of published information.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>15. Withdrawal Policy</summary>
        <div class="policy-content">
            <p>BJDD recognizes that authors may occasionally request the withdrawal of a manuscript due to genuine circumstances. However, manuscript withdrawal should be undertaken responsibly and only for valid reasons.</p>
            <h3>Withdrawal Before Peer Review</h3><p>Authors may request withdrawal of a manuscript before peer review begins by submitting a written request to the Editorial Office.</p>
            <h3>Withdrawal During Review</h3><p>Withdrawal requests submitted after the peer-review process has commenced must include a reasonable explanation. The Editorial Board reserves the right to evaluate such requests before granting approval.</p>
            <h3>Withdrawal After Acceptance</h3><p>Requests for withdrawal after acceptance are strongly discouraged because significant editorial and reviewer resources have already been invested in the manuscript.</p>
            <h3>Withdrawal After Publication</h3><p>Once an article has been published, withdrawal is generally not permitted. In such cases, concerns may be addressed through corrections, expressions of concern, or retraction procedures where appropriate.</p>
            <h3>Unethical Withdrawal</h3><p>Withdrawal requests intended to facilitate submission to another journal after extensive review or editorial processing may be considered unethical publishing behavior.</p><p>BJDD reserves the right to refuse withdrawal requests that conflict with accepted publication ethics and academic standards.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>16. Privacy Policy</summary>
        <div class="policy-content">
            <p>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD) is committed to protecting the privacy and confidentiality of authors, reviewers, editors, and readers. The journal collects and uses personal information solely for purposes directly related to manuscript submission, peer review, editorial management, publication, and communication activities.</p>
            <h3>Collection of Information</h3><p>The journal may collect personal information including:</p><ul><li>Author names and affiliations.</li><li>Email addresses and contact details.</li><li>ORCID IDs and academic profiles.</li><li>Reviewer and editor information.</li><li>Submission and publication-related records.</li></ul><p>Such information is collected only to facilitate the journal's publishing operations.</p>
            <h3>Use of Information</h3><p>Personal information may be used for manuscript processing and peer review, editorial communications, publication and indexing purposes, journal administration and record keeping, and improving journal services and user experience.</p><p>The journal does not sell, rent, or disclose personal information to third parties for commercial purposes.</p>
            <h3>Data Protection and Confidentiality</h3><p>BJDD takes reasonable administrative and technical measures to protect personal information from unauthorized access, disclosure, alteration, or misuse.</p><p>All manuscripts, reviewer reports, editorial communications, and personal information are treated as confidential and accessed only by authorized personnel.</p>
            <h3>Third-Party Services</h3><p>The journal may utilize third-party services for indexing, archiving, website hosting, or publication management. Such services may be subject to their respective privacy practices.</p>
            <h3>Policy Updates</h3><p>BJDD reserves the right to update this Privacy Policy periodically to reflect changes in legal requirements, technology, and publishing practices.</p><p>By submitting a manuscript or participating in the publication process, users consent to the collection of information as described in this policy.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>17. Disclaimer</summary>
        <div class="policy-content">
            <p>The views, opinions, interpretations, findings, and conclusions expressed in articles published by BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD) are solely those of the respective authors and do not necessarily reflect the views of the Editorial Board, reviewers, publisher, or affiliated institutions.</p><p>While the journal makes every effort to ensure the accuracy and quality of published content through editorial screening and peer review, BJDD does not guarantee the completeness, accuracy, or reliability of any information contained within published articles.</p><p>The journal shall not be held responsible for:</p><ul><li>Errors or omissions in published content.</li><li>Consequences arising from the use of published information.</li><li>Claims made by authors.</li><li>Research methodologies, findings, or interpretations presented in articles.</li></ul><p>Authors bear full responsibility for the originality, accuracy, ethical compliance, and legal validity of their work.</p><p>The publication of an article does not constitute endorsement by BJDD of the opinions, products, services, or viewpoints expressed therein.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>18. Article Processing Charges (APC) Policy</summary>
        <div class="policy-content">
            <p>BJDD is committed to maintaining a transparent and ethical publication process. To support editorial management, peer review, website maintenance, article production, indexing, digital preservation, and administrative operations, the journal may charge an Article Processing Charge (APC) for accepted manuscripts.</p>
            <h3>Purpose of APC</h3><p>The APC helps cover costs associated with editorial processing, peer-review management, copyediting and formatting, online publication, digital archiving and preservation, journal administration, and technical support.</p>
            <h3>Acceptance and APC</h3><p>Payment of APC does not influence editorial decisions and does not guarantee manuscript acceptance.</p><p>All submitted manuscripts undergo independent editorial evaluation and peer review based solely on academic merit, originality, quality, and relevance to the journal's scope.</p>
            <h3>Fee Transparency</h3><p>The applicable APC, if any, will be clearly communicated to authors before publication. Authors are encouraged to review the current fee structure on the journal website.</p>
            <h3>Refund Policy</h3><p>Once editorial processing or publication activities have commenced, APC payments are generally non-refundable except in exceptional circumstances determined by the Editorial Board.</p><p>BJDD is committed to maintaining transparency, fairness, and integrity in all publication-related financial matters.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>19. Archiving Policy</summary>
        <div class="policy-content">
            <p>BJDD recognizes the importance of preserving scholarly literature for future generations and ensuring long-term accessibility of published research.</p>
            <h3>Digital Preservation</h3><p>All published articles are archived electronically to safeguard scholarly content against data loss, technological changes, and service interruptions.</p>
            <h3>Journal Archive</h3><p>Published articles remain permanently accessible through the journal's official website and publication archives whenever possible.</p>
            <h3>Institutional and External Repositories</h3><p>The journal encourages the preservation and dissemination of published content through institutional repositories, academic databases, research repositories, library archives, and scholarly indexing services.</p>
            <h3>Long-Term Accessibility</h3><p>BJDD strives to ensure the long-term availability, discoverability, and accessibility of scholarly content through appropriate digital preservation strategies and archival practices.</p>
            <h3>Record Integrity</h3><p>Archived articles remain part of the permanent scholarly record. Any corrections, updates, expressions of concern, or retractions will be linked to the original publication to maintain transparency and research integrity.</p><p>The journal is committed to preserving academic knowledge and ensuring continued access to published research.</p>
        </div>
    </details>

    <details class="policy-card">
        <summary>20. DOI Policy</summary>
        <div class="policy-content">
            <p>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE (BJDD) supports the use of Digital Object Identifiers (DOIs) to enhance the visibility, accessibility, discoverability, and citation of scholarly publications.</p>
            <h3>Purpose of DOI</h3><p>A DOI provides a unique and permanent digital identifier for scholarly content, enabling reliable citation, indexing, and long-term access to published articles.</p>
            <h3>DOI Assignment</h3><p>Where applicable, BJDD assigns a DOI to eligible published articles. Once assigned, the DOI becomes a permanent identifier associated with the article and should be used in all citations and references.</p>
            <h3>Benefits of DOI</h3><p>The use of DOI helps improve article discoverability, facilitate accurate citation and referencing, support indexing and database integration, ensure persistent access to research, and enhance the visibility and impact of research.</p>
            <h3>Author Responsibilities</h3><p>Authors are encouraged to use assigned DOIs when citing articles and to ensure accurate citation of DOI-linked resources in their manuscripts.</p>
            <h3>Permanence of DOI</h3><p>DOIs remain permanent even if article URLs or website structures change. The journal is committed to maintaining DOI records and ensuring continued accessibility of DOI-linked content.</p><p>BJDD supports international best practices in scholarly publishing through the implementation of persistent digital identifiers and modern publication standards.</p>
        </div>
    </details>
</main>
@endsection
