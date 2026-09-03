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
        'view_count',
        'paper_url',
        'paper_pdf',
        'abstract', 
        'keywords',
        'certificate_path', 
        'received_at',
        'revised_at',
        'accepted_at',
        'published_online_at',
    ];

    protected $casts = [
        'year' => 'integer',
        'volume' => 'integer',
        'issue' => 'integer',
        'download_count' => 'integer',
        'view_count' => 'integer',
        'received_at' => 'date',
        'revised_at' => 'date',
        'accepted_at' => 'date',
        'published_online_at' => 'date',
    ];
}
