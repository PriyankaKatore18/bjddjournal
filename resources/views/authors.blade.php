<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors - BJDD Journal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #00004d;
            --secondary: #cc7a00;
            --accent1: #00cc00;
            --accent2: #003300;
            --dark: #000000;
            --light: #ffffff;
        }
        
        .bg-primary { background-color: var(--primary) !important; }
        .bg-secondary { background-color: var(--secondary) !important; }
        .text-primary { color: var(--primary) !important; }
        .text-secondary { color: var(--secondary) !important; }
        .btn-primary { 
            background-color: var(--primary); 
            border-color: var(--primary);
        }
        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }
        .btn-success {
            background-color: var(--accent1);
            border-color: var(--accent2);
            color: var(--dark);
        }
        .btn-success:hover {
            background-color: var(--accent2);
            border-color: var(--accent2);
            color: var(--light);
        }
        
        .authors-menu {
            background-color: rgba(0, 0, 77, 0.05);
            border-left: 4px solid var(--secondary);
            padding: 15px;
            position: sticky;
            top: 20px;
        }
        
        .authors-menu a {
            color: var(--primary);
            text-decoration: none;
            display: block;
            padding: 8px 0;
            transition: all 0.3s;
        }
        
        .authors-menu a:hover {
            color: var(--secondary);
            padding-left: 10px;
        }
        
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background-color: var(--primary);
            color: white;
            font-weight: bold;
        }
        
        .accordion-button:not(.collapsed) {
            background-color: var(--primary);
            color: white;
        }
        
        .download-btn {
            background-color: var(--secondary);
            color: white;
            border: none;
        }
        
        .download-btn:hover {
            background-color: var(--primary);
            color: white;
        }
        
        .badge-primary {
            background-color: var(--primary);
        }
        
        .badge-secondary {
            background-color: var(--secondary);
        }
        
        .timeline {
            position: relative;
            padding-left: 3rem;
            margin: 2rem 0;
        }
        
        .timeline:before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            height: 100%;
            width: 2px;
            background: var(--secondary);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }
        
        .timeline-item:before {
            content: '';
            position: absolute;
            left: -3rem;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--primary);
            border: 3px solid var(--secondary);
        }
        
        .header-logo {
            max-height: 60px;
        }
        
        .navbar {
            background-color: var(--primary);
        }
        
        .footer {
            background-color: var(--primary);
            color: white;
            padding: 40px 0;
        }
        
        .section-title {
            border-bottom: 2px solid var(--secondary);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .modal-content {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 25px rgba(0,0,0,0.2);
        }
        
        .modal-header {
            background-color: var(--primary);
            color: white;
            border-bottom: 2px solid var(--secondary);
        }
        
        .modal-title {
            font-weight: 700;
        }
        
        .modal-body h5 {
            color: var(--primary);
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
            margin-top: 20px;
            font-weight: 700;
        }
        
        .modal-body h6 {
            color: var(--secondary);
            margin-top: 15px;
            font-weight: 600;
        }
        
        .modal-body strong {
            color: var(--primary);
        }
        
        .modal-body ul, .modal-body ol {
            padding-left: 1.5rem;
        }
        
        .modal-body li {
            margin-bottom: 8px;
        }
        
        .info-highlight {
            background-color: rgba(0, 77, 0, 0.05);
            border-left: 4px solid var(--accent1);
            padding: 15px;
            margin: 15px 0;
            border-radius: 0 5px 5px 0;
        }
        
        .modal-footer {
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    @extends('layouts.app')
    
    @section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-md-4">
                <div class="authors-menu mb-4">
                    <h4 class="text-primary mb-3">Authors Resources</h4>
                    <a href="#" class="fw-bold" data-bs-toggle="modal" data-bs-target="#paperFormatModal">
                        <i class="fas fa-download me-2"></i>Paper Format (Word File Link)
                    </a>
                    <a href="{{ route('submit.paper') }}">
                        <i class="fas fa-paper-plane me-2"></i>Submit Paper
                    </a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#guidelinesModal">
                        <i class="fas fa-book me-2"></i>Authors Guidelines
                    </a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#publishModal">
                        <i class="fas fa-question-circle me-2"></i>How to Publish Paper?
                    </a>
                    <a href="#processingCharges">
                        <i class="fas fa-money-bill me-2"></i>Processing Charges
                    </a>
                </div>
                
                <div class="card">
                    <div class="card-header">Quick Facts</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Review Time
                                <span class="badge bg-primary rounded-pill">1-2 Days</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Publication Time
                                <span class="badge bg-primary rounded-pill">1-2 Days</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Indian Authors Fee
                                <span class="badge bg-secondary rounded-pill">₹900 INR</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                International Authors Fee
                                <span class="badge bg-secondary rounded-pill">$14 USD</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">Contact Information</div>
                    <div class="card-body">
                        <p><i class="fas fa-globe me-2 text-primary"></i> <strong>Website:</strong> <a href="https://www.bjddjournal.org" target="_blank">www.bjddjournal.org</a> </p>
                         <p><i class="fas fa-envelope me-2 text-primary"></i> <strong>Email:</strong> 
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=editor@bjddjournal.org&su=Inquiry&body=Dear%20BJDD%20Editorial%20Team%2C%0D%0A%0D%0A" 
                                    target="_blank">
                                    editor@bjddjournal.org
                                    </a>
                        </p>
                        <div class="d-grid gap-2">
                        <a href="{{ route('contact') }}" class="btn btn-primary"><i class="fas fa-envelope me-2"></i>Contact Us</a>
                    </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <h1 class="text-primary mb-4">Information for Authors</h1>
                
                <div class="card mb-4">
                    <div class="card-header">Scope and Focus</div>
                    <div class="card-body">
                        <p>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE is a <b>peer-reviewed, open-access, national-level multidisciplinary and multilingual journal </b>publishing high-quality research in English, Hindi, and Marathi. </p>
                        <p>The journal welcomes <b>original research articles, review papers, case studies, and short communications</b> from a wide range of disciplines including <b>Arts, Humanities, Commerce, Management, Science & Technology, Social Sciences, Education, Law, Agriculture, and Medicine. </b></p>
                        <p>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE aims to: </p>
                        <ul>
                            <li>Disseminate knowledge across diverse academic fields.</li>
                            <li>Encourage interdisciplinary and innovative research.</li>
                            <li>Provide a platform for both young researchers and experienced academicians.</li>
                            <li>Uphold high standards of ethics, originality, and academic integrity (COPE Guidelines). </li>
                        </ul>
                        <p>All submissions must be <b>original, unpublished, and plagiarism-free (≤6%).</b> </p>
                    </div>
                </div>
                
                <div class="accordion mb-4" id="authorsAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Manuscript Preparation
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#authorsAccordion">
                            <div class="accordion-body">
                                <h5>General Instructions</h5>
                                <ul>
                                    <li><strong>Languages Accepted:</strong> English, Hindi, and Marathi (other regional languages may be considered with prior approval).</li>
                                    <li><strong>Document Format:</strong> Submit in .doc or .docx format (MS Word).<i> PDF not accepted.</i></li>
                                    <li><strong>Length:</strong><ul> <li>Research Articles: 3000–5000 words </li><li> Review Papers: up to 5000 words</li><li> Short Communications: 1000–1500 words</li> </ul></li>
                                    <li><strong>Originality:</strong>Submissions must be original, unpublished, and plagiarism should not exceed 6%. </li>
                                </ul>
                                
                                <h5>Structure of the Manuscript</h5>
                                <ul>
                                    <li><strong>Title Page:</strong>Title, full name(s), designation(s), affiliation(s), email IDs of all authors, corresponding author details (name, phone, email), acknowledgments or funding support. </li>
                                    <li><strong>Abstract:</strong>150–250 words (purpose, methods, findings, conclusion).</li>
                                    <li><strong>Keywords:</strong> 4–6 keywords reflecting the scope of the paper. </li>
                                    <strong>Main Content:</strong><br>
                                    <ul style="margin-top:8px;">
                                        <li>Introduction (Context and objectives)</li>
                                        <li>Methodology (Research design, data, tools)</li>
                                        <li>Results (Data analysis, findings)</li>
                                        <li>Discussion (Interpretation and relevance)</li>
                                        <li>Conclusion (Summary &amp; suggestions for future research)</li>
                                    </ul>
                                    <li><strong>References:</strong>APA 7th edition preferred. MLA/Chicago/Harvard accepted if consistent.</li>
                                    <li><strong>Tables and Figures:</strong> Numbered, titled, and cited.</li>
                                </ul>
                                
                                <h5>Supplementary Materials</h5>
                                <p> Authors may include additional material (datasets, charts, appendices, audio/video links, etc.) if relevant. Such material will be hosted online with the article.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Submission and Review Process
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#authorsAccordion">
                            <div class="accordion-body">
                                <h5>Submission</h5>
                                <p>Authors can submit their manuscripts in <b>Word format (.doc/.docx only, PDF not accepted)</b> via</p>
                                <p>👉 Online submission through the <b>Submit Paper</b> button on our website</p>
                                <p>👉 OR via email : <a href="mailto:editor@bjddjournal.org">editor@bjddjournal.org</a></p>
                                <p>Make sure to attach:</p>
                                <ul>
                                    <li>Manuscript file (.doc/.docx)</li>
                                    <li>Any figures or supplementary files (if any)</li>
                                    <li>Declaration / Undertaking form (if required)</li>
                                </ul>
                                
                                <h5>Review & Publication Timeline</h5>
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <h6>Initial Screening (Within 24 hours):</h6>
                                        <p>Manuscripts checked for formatting, scope, language clarity, and<b> plagiarism (≤6% allowed).</b></p>
                                    </div>
                                    <div class="timeline-item">
                                        <h6>Peer Review (1–2 working days):</h6>
                                        <p>Double-blind review by subject experts.</p>
                                    </div>
                                    <div class="timeline-item">
                                        <h6>Acceptance or Revision Notification (Within 1–2 days):</h6>
                                        <p> Authors informed of acceptance, rejection, or required revisions.</p>
                                    </div>
                                    <div class="timeline-item">
                                        <h6>Publication (Within 1 day post-acceptance):</h6>
                                        <p> Accepted manuscripts published in the <b>current bi-monthly issue.</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Publication Ethics
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#authorsAccordion">
                            <div class="accordion-body">
                                <p>We strictly follow ethical publishing practices:</p>
                                <ul>
                                    <li><strong>Plagiarism Check:</strong> All papers are scanned through plagiarism detection tools</li>
                                    <li><strong>Conflict of Interest:</strong> Any potential conflicts must be disclosed</li>
                                    <li><strong>Ethical Approvals:</strong> Research involving humans or animals must include a statement of ethical clearance</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Post-Acceptance Process
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#authorsAccordion">
                            <div class="accordion-body">
                                <h5>Proof Approval</h5>
                                <p>Authors will receive galley proofs for review and must return them with corrections (if any) within <b>2–3 days.</b></p>
                                
                                <h5>Processing Fee</h5>
                                <p>To support our open-access and peer-review process:</p>
                                <ul>
                                    <li><b>₹900 INR for Indian Authors</b></li>
                                    <li><b>$14 USD for International Authors</b></li>
                                </ul>
                                <p>Authors receive:</p>
                                <ul>
                                    <li>E-Certificate of publication</li>
                                    <li>Digital copy of the journal issue</li>
                                    <li><i>(Optional: Print Copy can be requested with additional charges)</i></li>
                                </ul>
                                
                                <h5>Open Access Statement</h5>
                                <p>
                                    BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE follows a <b>100% open-access model.</b> All articles are freely available on 
                                    <a href="https://www.bjddjournal.org" target="_blank">www.bjddjournal.org</a> 
                                    for academic and research use. Authors retain copyright of their work. 
                                    The journal supports academic transparency and may adopt <b>Creative Commons Licensing (CC BY 4.0) </b>for wider dissemination.
                                </p>

                        </div>
                    </div>
                </div>
                
                <div class="card mb-4" id="submitPaper">
                    <div class="card-header">Submit Your Paper</div>
                    <div class="card-body">
                        <p>To submit your paper, please email us at <a href="mailto:editor@bjddjournal.org">editor@bjddjournal.org</a> with the following:</p>
                        <ol>
                            <li>Your manuscript in Word format</li>
                            <li>All figures and supplementary materials</li>
                            <li>Completed author declaration form (if applicable)</li>
                        </ol>
                       <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=editor@bjddjournal.org&su=Paper%20Submission&body=Dear%20BJDD%20Editorial%20Team%2C%0D%0A%0D%0APlease%20find%20attached%20my%20manuscript%20for%20consideration.%0D%0A%0D%0ATitle%3A%20%5BYour%20Paper%20Title%5D%0D%0AAuthor(s)%3A%20%5BYour%20Name(s)%5D%0D%0A%0D%0AThank%20you."
                            target="_blank"
                            class="btn btn-primary me-md-2">
                            <i class="fas fa-paper-plane me-2"></i>Submit via Gmail
                            </a>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#guidelinesModal">
                                <i class="fas fa-book me-2"></i>View Guidelines
                            </button>
                      </div>

                    </div>
                </div>
                
                <div class="card mb-4" id="processingCharges">
                    <div class="card-header">Processing Charges</div>
                    <div class="card-body">
                        <h5>Publication Charges</h5>
                        <p>At BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE, we believe in promoting quality research through an open-access, peer-reviewed, and affordable publishing model. To cover editorial, formatting, and digital distribution costs, the following charges apply:</p>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-success text-dark">Indian Authors</div>
                                    <div class="card-body">
                                        <p><strong>Standard Processing Fee: ₹900 INR</strong></p>
                                        <p>Includes:</p>
                                        <ul>
                                            <li>Double-blind peer review</li>
                                            <li>Editing and formatting support</li>
                                            <li>E-certificate of publication</li>
                                            <li>PDF version of the journal issue</li>
                                        </ul>
                                        <p><strong>DOI (Optional): ₹300 INR</strong></p>
                                        <p>If authors wish to assign a DOI to their published paper, an additional ₹300 will be charged. DOI assignment is optional and offered upon request.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-success text-dark">International Authors</div>
                                    <div class="card-body">
                                        <p><strong>Standard Processing Fee: $14 USD</strong></p>
                                        <p>Includes:</p>
                                        <ul>
                                            <li>Double-blind peer review</li>
                                            <li>Editing and formatting support</li>
                                            <li>E-certificate of publication</li>
                                            <li>PDF version of the journal issue</li>
                                        </ul>
                                        <p><strong>DOI (Optional): $5 USD</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <h5>Page Limit</h5>
                            <ul>
                                <li>Up to 10 pages (single-column format) included in the standard fee</li>
                                <li>No extra charges for up to 5 authors</li>
                                <li>For papers exceeding 10 pages or 5 authors, extra charges may apply (notified after review)</li>
                            </ul>
                            
                            <h5>Revisions</h5>
                            <ul>
                                <li>Minor Revisions: No additional charge</li>
                                <li>Major Revisions (requiring re-review): ₹300</li>
                            </ul>
                            
                            <h5>Payment Process</h5>
                            <ul>
                                <li>Fees are payable only after acceptance</li>
                                <li>Authors will receive detailed payment instructions via email</li>
                                <li>Accepted modes: UPI / Bank Transfer / Google Pay / PhonePe / Paytm</li>
                                <li>Please share payment screenshot or receipt for confirmation</li>
                            </ul>
                            
                          <div class="alert alert-info">
                                <strong>For Assistance:</strong> If you have any questions about fees, payment options, or invoices, write to us at 
                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to=editor@bjddjournal.org&su=Fee%20Inquiry&body=Dear%20BJDD%20Editorial%20Team%2C%0D%0A%0D%0A" 
                                target="_blank">
                                editor@bjddjournal.org
                                </a>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    
    <div class="modal fade" id="paperFormatModal" tabindex="-1" aria-labelledby="paperFormatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paperFormatModalLabel">Download Paper Format</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Click the button below to download the paper format template:</p>
                    <a href="https://docs.google.com/document/d/1Z8bpXSTGNcpDuV3F1wpgzWM5pLVHY1X0/export?format=docx" class="btn download-btn w-100" download="BJDD_Paper_Format.docx">
                        <i class="fas fa-download me-2"></i>Download Word Template
                    </a>
                    <p class="mt-3">Or view the template online:</p>
                    <a href="https://docs.google.com/document/d/1Z8bpXSTGNcpDuV3F1wpgzWM5pLVHY1X0/edit?usp=sharing&ouid=107421336101958810940&rtpof=true&sd=true" target="_blank" class="btn btn-outline-primary w-100">
                        <i class="fas fa-eye me-2"></i>View Online
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Guidelines Modal -->
    <div class="modal fade" id="guidelinesModal" tabindex="-1" aria-labelledby="guidelinesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="guidelinesModalLabel">Authors Guidelines</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="text-primary">BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</h5>
                    <p class="mb-3">🌐 <strong>Website:</strong> www.bjddjournal.org | 📧 <strong>Email:</strong> <a href="mailto:editor@bjddjournal.org">editor@bjddjournal.org</a></p>
                    
                    <p>We welcome your interest in publishing with BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE, a National Level, peer-reviewed, open-access platform for scholarly contributions from all academic fields and languages. Please read the following author guidelines carefully to ensure your submission is processed efficiently. </p>
                    
                    <h6>1. Scope and Focus</h6>
                    <p>BJDD accepts original research papers, review articles, short communications, and case studies across multiple disciplines—including Arts, Humanities, Science, Commerce, Management, Technology, Law, Education, Social Sciences, and more. </p>
                    <p>We proudly support multilingual research, accepting submissions in English, Hindi, and Marathi. </p>
                    <p>All submitted work should:</p>
                    <ul>
                        <li><strong>Align with BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE multidisciplinary and inclusive approach</strong></li>
                        <li><strong>Contribute original insights or findings</strong></li>
                        <li><strong>Follow ethical and academic standards</strong></li>
                    </ul>
                    
                    <h6>2. Manuscript Preparation</h6>
                    <p><strong>2.1 General Instructions</strong></p>
                    <ul>
                        <li><strong>Languages Accepted:</strong>English, Hindi, and Marathi (other regional languages may be considered with prior approval). </li>
                        <li><strong>Document Format:</strong> Submit in .doc or .docx format (MS Word). <i>PDF not accepted</i></li>
                        <li><strong>Length:</strong><ul> <li>Research Articles: 3000–5000 words </li><li> Review Papers: up to 5000 words</li><li> Short Communications: 1000–1500 words</li> </ul></li>
                        <li><strong>Originality:</strong>Submissions must be original, unpublished, and plagiarism should not exceed 6%.</li>
                    </ul>
                    
                    <p><strong>2.2 Structure of the Manuscript</strong></p>
                    <ul>
                        <li><strong>Title Page:</strong>Title, full name(s), designation(s), affiliation(s), email IDs of all authors, corresponding author details (name, phone, email), acknowledgments or funding support. </li>
                        <li><strong>Abstract:</strong>150–250 words (purpose, methods, findings, conclusion).</li>
                        <li><strong>Keywords:</strong>4–6 keywords reflecting the scope of the paper. </li>
                       <li>
                            <strong>Main Content:</strong><br>
                            <ul style="margin-top:8px;">
                                <li>Introduction (Context and objectives)</li>
                                <li>Methodology (Research design, data, tools)</li>
                                <li>Results (Data analysis, findings)</li>
                                <li>Discussion (Interpretation and relevance)</li>
                                <li>Conclusion (Summary &amp; suggestions for future research)</li>
                            </ul>
                        </li>

                        <li><strong>References:</strong> APA 7th edition preferred. MLA/Chicago/Harvard accepted if consistent. </li>
                        <li><strong>Tables and Figures:</strong> Numbered, titled, and cited.</li>
                    </ul>
                    
                    <h6>3. Supplementary Materials</h6>
                    <p> Authors may include additional material (datasets, charts, appendices, audio/video links, etc.) if relevant. Such material will be hosted online with the article.</p>
                    <h6>4. Review & Publication Policy </h6>
                    <ul>
                        <li>Double-blind peer review process.</li>
                        <li>Review & acceptance decision within 2 days.</li>
                        <li>Accepted papers published online within 1 day of acceptance.</li>
                    </ul>
                    <h6>5. Ethics & Copyright </h6>
                    <ul>
                        <li>Authors must submit a Copyright Transfer & Undertaking Form along with the paper.</li>
                        <li>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE follows COPE (Committee on Publication Ethics) guidelines. </li>
                    </ul>
                    <div class="info-highlight">
                        <h6 class="mt-0">Important Note</h6>
                        <p class="mb-0">All submissions must follow these guidelines to be considered for publication. Papers not adhering to these guidelines may be returned for correction before review.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- How to Publish Modal -->
    <div class="modal fade" id="publishModal" tabindex="-1" aria-labelledby="publishModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="publishModalLabel">How to Publish Paper? (Peer Review Process)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                   <p class="mb-3">
                    <strong>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</strong><br>
                    📧 <strong>Email:</strong> <a href="mailto:editor@bjddjournal.org">editor@bjddjournal.org</a> | <br>
                    🌐 <strong>Website:</strong> <a href="https://www.bjddjournal.org" target="_blank">www.bjddjournal.org</a>
                    </p>

                    
                    <h6>What is Peer Review?</h6>
                    <p>Peer review ensures that each published research paper meets essential standards of quality, validity, and relevance. At BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE, all submissions are evaluated by expert reviewers through a double-blind process, keeping both authors and reviewers anonymous. </p>
                    <p>This helps maintain credibility, integrity, and academic excellence, while also supporting authors in improving their work. </p>
                    
                    <h6>How Peer Review Works at BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</h6>
                    <ol>
                        <li>
                            <strong>Manuscript Submission:</strong><br>
                            Authors must submit their papers in Word format (<code>.doc</code>/<code>.docx</code> only, PDF not accepted).<br>
                            Upload directly via the website by clicking the button below:<br><br>
                            <a class="btn btn-warning ms-2 py-2 px-4 btn-blink" href="{{ route('submit.paper') }}">
                                Submit Paper
                            </a>
                        </li>

                        <li><strong>Initial Editorial Review:</strong> Screening for plagiarism (≤6% allowed), formatting, language clarity, and alignment with the journal’s scope.</li>
                        <li><strong>Reviewer Assignment:</strong> If approved, the manuscript is forwarded to subject experts for double-blind peer review.</li>
                        <li><strong>Review Evaluation:</strong>Reviewers assess originality, methodology, relevance, quality of arguments, data, and presentation.</li>
                        <li><strong>Feedback & Author Revision:</strong> Authors may be asked to revise and resubmit based on reviewer feedback.</li>
                        <li><strong>Final Decision:</strong> Acceptance, Revision, or Rejection by the editorial board.</li>
                        <li><strong>Publication:</strong> Accepted papers are published in the current Bi-Monthly Issue and shared with the author.</li>
                    </ol>
                    
                    <h6>Why Peer-Reviewed Journals Are Important</h6>
                    <ul>
                        <li><strong>Enhances credibility and scholarly value</strong></li>
                        <li><strong>Provides constructive expert feedback</strong></li>
                        <li><strong>Helps career growth and recognition</strong></li>
                        <li><strong>Increases reach and readership</strong></li>
                        <li><strong>Builds trust among academic peers</strong></li>
                    </ul>
                    
                    <h6>Why Choose BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE?</h6> 
                    <div class="info-highlight">
                        <ul class="mb-0">
                            <li>Expert reviewers from reputed institutions.</li>
                            <li>Fast Review (2 Days) + Publication (1 Day after acceptance)</li>
                            <li>Transparent and ethical editorial process</li>
                            <li>Multilingual submissions (English, Hindi, Marathi) supported</li>
                            <li>Affordable Publication Fee: ₹900 (Indian Authors) | $14 (Foreign Authors)</li>
                            <li>Full Open Access – free to all readers</li>
                        </ul>
                    </div>
                    
                    <h6>Our Review Philosophy</h6>
                    <p>BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE believes in: </p>
                    <ul>
                        <li><strong>Maintaining fairness and ethics</strong></li>
                        <li><strong>Providing constructive reviewer comments</strong></li>
                        <li><strong>Ensuring equal opportunity for all contributors</strong></li>
                        <li><strong>Promoting multilingual research</strong></li>
                    </ul>
                    
                    <h6>Become a Reviewer</h6>
                    <p>Are you an academic, researcher, or faculty member?</p>
                    <p>Send your CV and subject expertise to: 📧 <a href="mailto:editor@bjddjournal.org?subject=Reviewer Application">editor@bjddjournal.org</a></p>
                    <p>We welcome reviewers who want to guide authors and promote academic research quality. </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>