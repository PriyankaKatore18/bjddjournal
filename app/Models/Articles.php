<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'abstract', 'author_id', 'pdf_path', 'status'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
