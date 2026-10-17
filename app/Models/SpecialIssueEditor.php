<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialIssueEditor extends Model
{
    use HasFactory;

    protected $fillable = [
        'special_issue_id',
        'name',
        'position',
        'department',
        'institution',
        'photo',
        'display_order',
    ];

    protected $casts = [
        'display_order' => 'integer',
    ];

    public function specialIssue()
    {
        return $this->belongsTo(SpecialIssue::class);
    }
}
