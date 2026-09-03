<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorCounter extends Model
{
    protected $fillable = [
        'total_visits',
    ];

    protected $casts = [
        'total_visits' => 'integer',
    ];
}
