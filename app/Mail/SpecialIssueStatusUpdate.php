<?php

namespace App\Mail;

use App\Models\PaperSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SpecialIssueStatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PaperSubmission $submission)
    {
    }

    public static function subjects(): array
    {
        return [
            'editorial_screening' => 'Manuscript Under Editorial Screening',
            'revision_required' => 'Action Required: Manuscript Revision',
            'under_review' => 'Manuscript Under Review',
            'accepted' => 'Congratulations! Manuscript Accepted for Publication',
            'rejected' => 'Editorial Decision on Manuscript',
            'payment_pending' => 'Action Required: Publication Fee Payment',
            'published' => 'Congratulations! Your Research Article Has Been Published',
        ];
    }

    public function envelope(): Envelope
    {
        $subject = self::subjects()[$this->submission->status] ?? 'Manuscript Status Update';

        return new Envelope(
            subject: $subject.' | '.$this->submission->paper_id,
            replyTo: [
                new Address(config('mail.reply_to.address'), config('mail.reply_to.name')),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.special-issue-status-update',
            text: 'emails.special-issue-status-update-text',
        );
    }
}
