<?php

namespace App\Mail;

use App\Models\PaperSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SpecialIssueSubmissionScreening extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PaperSubmission $submission)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Manuscript Under Editorial Screening | '.$this->submission->paper_id,
            replyTo: [
                new Address(
                    config('mail.reply_to.address'),
                    config('mail.reply_to.name'),
                ),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.special-issue-submission-screening',
            text: 'emails.special-issue-submission-screening-text',
        );
    }
}
