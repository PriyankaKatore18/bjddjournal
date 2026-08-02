<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'paper_title',
        'author_name',
        'registration_id',
        'published_paper_id',
        'year',
        'volume',
        'issue',
        'issue_range',
        'eissn',
        'country',
        'crossref_doi',
        'page_nos',
        'download_count', 
        'paper_url',
        'paper_pdf',
        'abstract', 
        'keywords',
        'certificate_path', 
    ];

    protected $casts = [
        'year' => 'integer',
        'volume' => 'integer',
        'issue' => 'integer',
        'download_count' => 'integer',
    ];
}
