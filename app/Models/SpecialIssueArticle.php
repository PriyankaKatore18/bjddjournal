<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialIssueArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'special_issue_id',
        'paper_id',
        'article_title',
        'article_type',
        'language',
        'main_author',
        'co_authors',
        'affiliation',
        'country',
        'pages',
        'published_date',
        'doi',
        'eissn',
        'publisher',
        'final_pdf_path',
        'certificate_path',
        'abstract',
        'keywords',
        'status',
        'display_order',
        'download_count',
    ];

    protected $casts = [
        'published_date' => 'date',
        'display_order' => 'integer',
    ];

    public function specialIssue()
    {
        return $this->belongsTo(SpecialIssue::class);
    }
}
