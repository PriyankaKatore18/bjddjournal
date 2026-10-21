<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'special_issue_id',
        'type',
        'title',
        'subtitle',
        'institution',
        'department',
        'conference_date',
        'mode',
        'status',
        'submission_open',
        'submission_deadline',
        'cover_image',
        'cover_pdf_path',
        'index_pdf_path',
        'full_issue_pdf_path',
        'about_conference',
        'editorial_details',
    ];

    protected $casts = [
        'conference_date' => 'date',
        'submission_open' => 'boolean',
        'submission_deadline' => 'date',
    ];

    public function acceptsSubmissions(): bool
    {
        return in_array($this->status, ['publication_in_progress', 'published'], true)
            && $this->submission_open
            && (! $this->submission_deadline || today()->lte($this->submission_deadline));
    }

    public function articles()
    {
        return $this->hasMany(SpecialIssueArticle::class);
    }

    public function submissions()
    {
        return $this->hasMany(PaperSubmission::class);
    }

    public function publishedArticles()
    {
        return $this->articles()
            ->where('status', 'published')
            ->orderBy('display_order')
            ->orderBy('id');
    }

    public function editors()
    {
        return $this->hasMany(SpecialIssueEditor::class)->orderBy('display_order')->orderBy('id');
    }
}
