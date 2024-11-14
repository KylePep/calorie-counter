<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalorieDay extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'food_items' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
