<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'abstract', // Added
        'volume',
        'number',
        'publish_date',
        'registration_id',
        'published_paper_id',
        'year',
        'approved_eissn',
        'country',
        'crossref_doi_member_id',
        'page_no',
        'downloads_count',
        'published_paper_url',
        'published_paper_pdf',
        'cover_image',
        'paper_certificate', // Added
    ];

    /**
     * Increment download count
     */
    public function incrementDownloadCount()
    {
        $this->downloads_count++;
        $this->save();
    }
}
