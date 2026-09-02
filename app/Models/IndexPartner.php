<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndexPartner extends Model
{
    protected $table = 'index_partners';

    protected $fillable = [
        'name',
        'icon',
        'url',
    ];
}
