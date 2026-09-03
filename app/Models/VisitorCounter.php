<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorCounter extends Model
{
    protected $fillable = [
        'total_visits',
        'today_visits',
        'visit_date',
    ];

    protected $casts = [
        'total_visits' => 'integer',
        'today_visits' => 'integer',
        'visit_date' => 'date',
    ];

    public static function formatIndian(int $number): string
    {
        $number = (string) max(0, $number);

        if (strlen($number) <= 3) {
            return $number;
        }

        $lastThree = substr($number, -3);
        $remaining = substr($number, 0, -3);

        return preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $remaining) . ',' . $lastThree;
    }
}
