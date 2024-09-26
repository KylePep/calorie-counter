<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandedFoodItem {

    public $fdcId;
    public $description;
    public $brandName;
    public $brandOwner;
    public $servingSize;
    public $servingSizeUnit;
    public $foodCategory;
    public $labelNutrients;
    public $marketCountry;
    public $ingredients;
    public $foodNutrients;

    public static function fromApiResponse(array $data) {
        $item = new self();

        $item->fdcId = $data['fdcId'] ?? null;
        $item->description = $data['description'] ?? '';
        $item->brandName = $data['brandName'] ?? '';
        $item->brandOwner = $data['brandOwner'] ?? '';
        $item->servingSize = $data['servingSize'] ?? 0;
        $item->servingSizeUnit = $data['servingSizeUnit'] ?? '';
        $item->foodCategory = $data['foodCategory'] ?? '';
        $item->labelNutrients = $data['labelNutrients'] ?? [];
        $item->marketCountry = $data['marketCountry'] ?? '';
        $item->ingredients = $data['ingredients'] ?? '';
        $item->foodNutrients = $data['foodNutrients'] ?? [];

        return $item;
    }
}
