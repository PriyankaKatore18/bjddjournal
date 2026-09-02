<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentIssue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'volume',
        'issue',
        'month_year',
        'e_issn',
        'last_submission_date',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_submission_date' => 'date',
        'is_active' => 'boolean'
    ];

    /**
     * Get the active current issue
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the formatted issue display
     *
     * @return string
     */
    public function getFormattedIssueAttribute()
    {
        return "Volume {$this->volume}, Issue {$this->issue} ({$this->month_year})";
    }

    /**
     * Get the formatted last submission date
     *
     * @return string
     */
    public function getFormattedLastSubmissionDateAttribute()
    {
        return $this->last_submission_date ? $this->last_submission_date->format('jS F Y') : 'Not set';
    }
}