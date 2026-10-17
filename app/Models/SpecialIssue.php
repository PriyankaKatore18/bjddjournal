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
        'cover_image',
        'cover_pdf_path',
        'index_pdf_path',
        'full_issue_pdf_path',
        'about_conference',
        'editorial_details',
    ];

    protected $casts = [
        'conference_date' => 'date',
    ];

    public function articles()
    {
        return $this->hasMany(SpecialIssueArticle::class);
    }

    public function publishedArticles()
    {
        return $this->articles()->where('status', 'published');
    }

    public function editors()
    {
        return $this->hasMany(SpecialIssueEditor::class)->orderBy('display_order')->orderBy('id');
    }
}
