<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_path',
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
        'status'
    ];

    protected $casts = [
        'co_authors' => 'array'
    ];

    // Add accessor for file URL
    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}