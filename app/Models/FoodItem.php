<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'foodNutrients' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
