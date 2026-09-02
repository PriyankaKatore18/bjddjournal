<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalTeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'position',
        'department',
        'institution',
        'email',
        'phone',
        'address',
        'qualification',
        'photo', // New field
        'link',  // New field
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Scope for different types
    public function scopeChiefEditors($query)
    {
        return $query->where('type', 'chief_editor');
    }

    public function scopeEditors($query)
    {
        return $query->where('type', 'editor');
    }

    public function scopeReviewers($query)
    {
        return $query->where('type', 'reviewer');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor for photo URL
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return null;
    }

    // Check if has photo
    public function hasPhoto()
    {
        return !empty($this->photo);
    }

    // Check if has link
    public function hasLink()
    {
        return !empty($this->link);
    }
}