<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'special_issue_id',
        'paper_id',
        'previous_paper_id',
        'title',
        'file_path',
        'plagiarism_report_path',
        'ai_report_path',
        'research_area',
        'author_main_name',
        'author_main_designation',
        'author_main_institute',
        'author_main_email',
        'author_main_mobile',
        'co_authors',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'country',
        'pincode',
        'originality_declaration',
        'authorship_consent',
        'ethics_declaration',
        'journal_policies',
        'final_confirmation',
        'submission_token',
        'status',
        'editorial_remarks',
        'publication_fee',
        'payment_link',
        'article_url',
        'submitted_at',
        'email_sent_at',
        'email_error',
    ];

    protected $casts = [
        'co_authors' => 'array',
        'originality_declaration' => 'boolean',
        'authorship_consent' => 'boolean',
        'ethics_declaration' => 'boolean',
        'journal_policies' => 'boolean',
        'final_confirmation' => 'boolean',
        'submitted_at' => 'datetime',
        'email_sent_at' => 'datetime',
        'publication_fee' => 'decimal:2',
    ];

    // Add accessor for file URL
    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    public function specialIssue()
    {
        return $this->belongsTo(SpecialIssue::class);
    }
}
