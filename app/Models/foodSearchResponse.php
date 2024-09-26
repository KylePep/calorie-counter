<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class foodSearchResponse extends Model
{
    // use HasFactory;

    public $totalHits;
    public $currentPage;
    public $totalPages;
    public $foods;

    public static function fromApiResponse(array $data)
    {
        $instance = new self();

        $instance->totalHits = $data['totalHits'] ?? 0;
        $instance->currentPage = $data['currentPage'] ?? 1;
        $instance->totalPages = $data['totalPages'] ?? 1;

        $instance->foods = array_map(function($foodItem) {
            return BrandedFoodItem::fromApiResponse($foodItem);
        }, $data['foods'] ?? []);

        return $instance;
    }
}
