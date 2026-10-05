<?php

namespace App\Mail;

use App\Models\PaperSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaperSubmissionAcknowledgement extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PaperSubmission $submission)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Manuscript Submission Acknowledgement - '.$this->submission->paper_id.' | BJDD',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.paper-submission-acknowledgement',
        );
    }
}
