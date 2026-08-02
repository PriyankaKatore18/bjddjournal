@extends('layouts.app')

@section('content')
<style>
    
    .contact-container {
        display: flex;
        justify-content: space-between;
        gap: 30px;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
    }

    .left-sidebar, .right-sidebar {
        flex: 0 0 250px;
    }

    .main-content {
        flex: 1;
        min-width: 300px; 
    }

    .box {
        background-color: #ffffff;
        border: 1px solid #00004d; 
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
    }

    .box-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #00004d; 
        margin-bottom: 15px;
        border-bottom: 2px solid #cc7a00; 
        padding-bottom: 10px;
    }

    .box ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .box ul li {
        margin-bottom: 10px;
    }

    .box ul li a {
        text-decoration: none;
        color: #000000;
        display: block;
        padding: 5px;
        transition: color 0.3s ease, background-color 0.3s ease;
    }

    .box ul li a:hover {
        color: #ffffff;
        background-color: #cc7a00; 
    }

    
    .btn.blinking-button {
        background-color: #cc7a00; 
        color: #ffffff;
        border-color: #cc7a00;
        animation: blink 1s linear infinite;
        display: block;
        text-align: center;
        margin-bottom: 15px;
        padding: 12px;
        border-radius: 4px;
        font-weight: bold;
        text-decoration: none;
    }
    .btn.blinking-button:hover {
        animation: none;
        background-color: #00004d;
        border-color: #00004d;
    }
        
    .btn.submit-btn {
        background-color: #cc7a00;
        color: #ffffff;
        border: none;
        width: auto;
        padding: 10px 20px; 
    }

    .page-title {
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
        font-size: 36px;
        color: #00004d;
    }

    .contact-info p {
        margin: 5px 0;
        line-height: 1.6;
    }
    .contact-info strong {
        font-weight: bold;
        color: #00004d;
    }
    .contact-info a {
        color: #cc7a00;
        text-decoration: none;
    }
    .contact-info hr {
        border-top: 1px solid #cc7a00;
        margin: 20px 0;
    }
   
    .contact-info-container,
    .contact-form-container {
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #00004d;
        border-radius: 8px;
        background-color: #ffffff;
    }

    /* Contact form styling */
    .contact-form h3 {
        color: #00004d;
        font-weight: normal;
        margin-top: 0;
    }
    .contact-form label {
        display: block;
        margin-bottom: 5px;
        color: #00004d;
        font-weight: bold;
    }
    .contact-form input[type="text"],
    .contact-form input[type="email"],
    .contact-form input[type="tel"],
    .contact-form textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 5px;
        border: 1px solid #cc7a00;
        border-radius: 4px;
        box-sizing: border-box;
        background-color: #f9f9f9;
        color: #000000;
    }
    .contact-form textarea {
        height: 120px;
        resize: vertical;
    }

    .recaptcha {
        display: flex;
        align-items: center;
        border: 1px solid #00004d;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #f9f9f9;
        width: 300px;
    }

    .recaptcha input[type="checkbox"] {
        margin-right: 10px;
    }

    .recaptcha img {
        height: 40px;
        margin-left: auto;
    }

    .turnitin-logo {
        max-width: 150px;
        display: block;
        margin: 10px auto 0;
    }
    .call-for-paper, .issn-box, .doi-box, .license-box {
        text-align: center;
    }
    .issn-box img, .doi-box img {
        max-width: 100%;
    }
    .indexing-partners ul {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    .indexing-partners img {
        max-width: 100%;
        height: auto;
        border: 1px solid #ddd;
        padding: 5px;
        background-color: #f9f9f9;
    }

    .contact-method {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px dashed #cc7a00;
    }
    
    .contact-method:last-child {
        border-bottom: none;
    }
    
    .contact-method h3 {
        color: #00004d;
        font-size: 1.3rem;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }
    
    .contact-method h3 .icon {
        margin-right: 10px;
        font-size: 1.5rem;
    }
    
    .social-links {
        display: flex;
        gap: 15px;
        margin-top: 10px;
    }
    
    .social-links a {
        display: inline-block;
        padding: 8px 15px;
        background-color: #00004d;
        color: white;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    
    .social-links a:hover {
        background-color: #cc7a00;
    }
    
    .whatsapp-link {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 15px;
        background-color: #25D366;
        color: white;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    
    .whatsapp-link:hover {
        background-color: #128C7E;
    }

    @keyframes blink {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.7;
            transform: scale(0.98);
        }
    }
    
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    
    .alert-success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }
    
    .alert-danger {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }

    .error-message {
        color: #d9534f;
        font-size: 0.9em;
        margin-top: -5px;
        margin-bottom: 10px;
        font-style: italic;
    }

    @media (max-width: 1100px) {
        .contact-container {
            flex-direction: row;
            justify-content: center;
            padding: 15px;
        }
        
        .left-sidebar, .right-sidebar {
            flex: 0 0 220px;
            max-width: 220px;
        }
        
        .main-content {
            min-width: 400px;
            max-width: 500px;
            flex: 1;
        }
    }
    
    @media (max-width: 900px) {
        .contact-container {
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        
        .left-sidebar, .right-sidebar {
            width: 100%;
            max-width: 100%;
            flex: 0 0 auto;
        }
        
        .main-content {
            min-width: 100%;
            max-width: 100%;
            order: -1; 
        }
        
        .page-title {
            font-size: 28px; 
        }
        
        .indexing-partners ul {
            grid-template-columns: repeat(3, 1fr); 
        }
    }
    
    @media (max-width: 768px) {
        .contact-container {
            padding: 10px;
            gap: 15px;
        }
        
        .box {
            padding: 15px;
        }
        
        .contact-info-container, 
        .contact-form-container {
            padding: 15px;
        }
        
        .indexing-partners ul {
            grid-template-columns: repeat(2, 1fr); 
        }
        
        .social-links {
            flex-wrap: wrap;
        }
        
        .page-title {
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .contact-method h3 {
            font-size: 1.1rem;
        }
    }
    
    @media (max-width: 480px) {
        .contact-form input[type="text"],
        .contact-form input[type="email"],
        .contact-form input[type="tel"],
        .contact-form textarea {
            padding: 8px;
        }
        
        .btn.blinking-button,
        .btn.submit-btn {
            padding: 10px 15px;
            font-size: 14px;
        }
        
        .indexing-partners ul {
            grid-template-columns: 1fr; 
        }
        
        .contact-method h3 {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .contact-method h3 .icon {
            margin-bottom: 5px;
        }
    }
    
</style>

<div class="contact-container">

    <!-- <div class="left-sidebar">

        <a href="{{ route('submit.paper') }}" class="btn blinking-button">Submit Research Paper</a>

        <div class="box">
            <p>Plagiarism is checked by the leading plagiarism checker</p>

             <img src="{{ asset('public/assets/img/plag.png') }}" alt="issn Logo">
        </div>

        <div class="box call-for-paper">
            <div class="box-title">Call for Paper</div>
            <p>Volume 1 ✱ Issue 3<br>(September- October 2025)</p>
            <a href="{{ route('submit.paper') }}">
                        <i class="fas fa-paper-plane me-2"></i>Submit your research paper
                    </a>
        </div>

        <div class="box indexing-partners">
            <div class="box-title">Indexing Partners</div>
            <ul>
                <li><img src="https://i.imgur.com/kY7qV9g.png" alt="Academia.edu"></li>
                <li><img src="https://i.imgur.com/P0m0g9c.png" alt="Refseek"></li>
                <li><img src="https://i.imgur.com/eB3b6zO.png" alt="ResearcherID"></li>
                <li><img src="https://i.imgur.com/2Yf8z0c.png" alt="BASE"></li>
                <li><img src="https://i.imgur.com/T0a3j8C.png" alt="ResearchGate"></li>
                <li><img src="https://i.imgur.com/w9F1w3S.png" alt="CiteSeerX"></li>
                <li><a href="#">Indexing Partner 7</a></li>
                <li><a href="#">Indexing Partner 8</a></li>
                <li><a href="#">Indexing Partner 9</a></li>
                <li><a href="#">Indexing Partner 10</a></li>
                <li><a href="#">Indexing Partner 11</a></li>
                <li><a href="#">Indexing Partner 12</a></li>
                <li><a href="#">Indexing Partner 13</a></li>
                <li><a href="#">Indexing Partner 14</a></li>
                <li><a href="#">Indexing Partner 15</a></li>
                <li><a href="#">Indexing Partner 16</a></li>
                <li><a href="#">Indexing Partner 17</a></li>
                <li><a href="#">Indexing Partner 18</a></li>
            </ul>
        </div>
    </div> -->

    <div class="main-content">
        <h1 class="page-title">Contact - BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger">
                <p><strong>Please check the following:</strong></p>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="contact-info-container">
            <div class="contact-info">
                <p><strong>Journal:</strong> BODHIVRUKSHA JOURNAL OF DIVERSE DISCIPLINE</p>
                <p>📧 <strong>Email:</strong> <a href="mailto:editor@bjddjournal.org">editor@bjddjournal.org</a></p>
                <p>🌐 <strong>Website:</strong> <a href="https://www.bjddjournal.org" target="_blank">www.bjddjournal.org</a></p>
                
                <hr>
                
                <p>If you have any questions regarding manuscript submission, publication process, reviewer registration, or any general inquiries, we are here to help.</p>
                
                <p>Before reaching out, we encourage you to check our <a href="#" style="color:#cc7a00; font-weight:bold;"><a href="{{ route('faq') }}" style="color: #cc7a00;">FAQ's Section</a></a> for quick answers to commonly asked questions.</p>
                
                <p>If your query is not addressed there, feel free to contact us through any of the following options:</p>
                
                <div class="contact-method">
                    <h3><span class="icon">📧</span> Email Support</h3>
                    <p>You can write to us at:</p>
                    <p><a href="mailto:editor@bjddjournal.org">editor@bjddjournal.org</a></p>
                    <p><em>(We usually respond within 24–48 hours)</em></p>
                </div>
                
               <div style="font-family: Arial, sans-serif; color: #444; max-width: 500px; margin: 20px 0;">
                    <h3 style="display: flex; align-items: center; font-size: 1.3rem;">
                        <span style="margin-right: 10px;">📞</span> Call / WhatsApp
                    </h3>
                    <p>📱 <strong>Contact Number:</strong> +91 8421071634</p>
                    <p>🕒 <strong>Available:</strong> 10:00 AM to 7:00 PM IST (Monday to Saturday)</p>
                    <a href="https://wa.me/8421071634" target="_blank"
                    style="display: inline-block; margin-top: 10px; padding: 10px 20px; background-color: #25D366; color: #fff; font-weight: bold; text-decoration: none; border-radius: 5px; animation: blink 1s infinite;">
                        <span style="margin-right: 8px;">💬</span> WhatsApp Direct Message
                    </a>
                    <style>
                        @keyframes blink {
                            0%, 50%, 100% { opacity: 1; }
                            25%, 75% { opacity: 0.7; }
                        }
                    </style>
                </div>
                
                <div class="contact-method">
                    <h3><span class="icon">📘</span> Social Media</h3>
                    <p>Stay updated with our announcements and publication updates via:</p>

                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

                    <div class="social-links">
                        <a href="https://www.facebook.com/bjddjournal?utm_source=chatgpt.com" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/bjddjournal?utm_source=chatgpt.com" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        
        <div class="contact-form-container">
            <div class="contact-form">
                <h3>Send Us a Message</h3>
                <p>Alternatively, you can fill out the form below and our editorial team will get back to you shortly:</p>
                <form method="POST" action="{{ route('contact.submit') }}" id="contactForm">
                    @csrf
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="error-message">
                            @if($errors->first('name') == 'The name field is required.')
                                Please provide your name
                            @else
                                {{ $message }}
                            @endif
                        </div>
                    @enderror

                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="error-message">
                            @if($errors->first('email') == 'The email field is required.')
                                Please provide your email
                            @elseif(str_contains($errors->first('email'), 'valid'))
                                Please enter a valid email address
                            @else
                                {{ $message }}
                            @endif
                        </div>
                    @enderror

                    <label for="phone">Phone Number (Optional)</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" pattern="[0-9]{10}" maxlength="10" oninput="validatePhone(this)">
                    @error('phone')
                        <div class="error-message">
                            @if(str_contains($errors->first('phone'), 'valid'))
                                Please enter a valid 10-digit phone number
                            @else
                                {{ $message }}
                            @endif
                        </div>
                    @enderror

                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required>
                    @error('subject')
                        <div class="error-message">
                            @if($errors->first('subject') == 'The subject field is required.')
                                Please provide a subject
                            @else
                                {{ $message }}
                            @endif
                        </div>
                    @enderror

                    <label for="message">Message</label>
                    <textarea id="message" name="message" required minlength="10">{{ old('message') }}</textarea>
                    @error('message')
                        <div class="error-message">
                            @if($errors->first('message') == 'The message field is required.')
                                Please provide your message
                            @elseif(str_contains($errors->first('message'), 'at least'))
                                Your message should be at least 10 characters
                            @else
                                {{ $message }}
                            @endif
                        </div>
                    @enderror

                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 15px;">
                      
                        <button type="submit" class="btn submit-btn">📤 Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- 
    <div class="right-sidebar">
        {{-- <div class="box issn-box">

             <img src="{{ asset('public/assets/img/issn.png') }}" alt="ISSN">
        </div> --}}

        <div class="box doi-box">

            <img src="{{ asset('public/assets/img/doi.png') }}" alt="doi">
            <p>DOI is assigned to each research paper published in our journal.</p>
            
        </div>

        <div class="box downloads-box">
            <div class="box-title">Downloads</div>
            <ul>
                <li><a href="javascript:void(0)" onclick="window.open('https://docs.google.com/document/d/1Z8bpXSTGNcpDuV3F1wpgzWM5pLVHY1X0/edit?usp=sharing&ouid=107421336101958810940&rtpof=true&sd=true', '_blank')" style="color: #000; text-decoration: none;">Research Paper Format</a></li>
                <li><a href="#">Copyright Permission Form and Undertaking Form</a></li>

            </ul>
        </div>
        
        <div class="box license-box">
            <p>All research papers published on this website are licensed under <a href="#">Creative Commons Attribution-ShareAlike 4.0 International License</a>, and all rights belong to their respective authors/researchers.</p>
             {{-- <img src="{{ asset('public/assets/img/issn.png') }}" alt="BJDD Logo"> --}}
        </div>

    </div> -->
</div>

<script>

    function validatePhone(input) {

        input.value = input.value.replace(/\D/g, '');
        
        if (input.value.length > 10) {
            input.value = input.value.slice(0, 10);
        }
    }
    

    document.getElementById('contactForm').addEventListener('submit', function(event) {
        const phoneInput = document.getElementById('phone');
        const phoneValue = phoneInput.value.trim();

        if (phoneValue !== '' && !/^\d{10}$/.test(phoneValue)) {
            event.preventDefault();
            alert('Please enter a valid 10-digit phone number (digits only).');
            phoneInput.focus();
        }
    });

    if (!document.querySelector('meta[name="viewport"]')) {
        const meta = document.createElement('meta');
        meta.name = 'viewport';
        meta.content = 'width=device-width, initial-scale=1.0';
        document.getElementsByTagName('head')[0].appendChild(meta);
    }
</script>
@endsection