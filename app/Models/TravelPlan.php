<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'destination',
        'dates',
        'days',
        'flight_data',
        'hotel_data',
        'image'
    ];

    // To automatycznie przekształca JSON z bazy w tablice PHP
    protected $casts = [
        'days' => 'array',
        'flight_data' => 'array',
        'hotel_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
