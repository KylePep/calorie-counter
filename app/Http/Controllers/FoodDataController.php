<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FoodDataController extends Controller
{
    public function getFoodData()
    {

        $apiKey = env('FOOD_DATA_API_KEY');

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->get('https://api.nal.usda.gov/fdc/v1/food/534358');


        if($response->successful()){
            return $response->json();
        } else {
            return response()->json(['error'=> 'Failed to fetch Food Data'], 500);
        }
    }
}
