<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FoodUsdaController extends Controller
{

    //Returns a specif food item from the usda database by fdcId
    public function getById($id)
    {
        $apiKey = env('FOOD_DATA_API_KEY');
        $url = "https://api.nal.usda.gov/fdc/v1/food/{$id}?api_key={$apiKey}";

        $response = Http::get($url);

        if($response->successful() ){
            return $response->json();
        }

        return response()->json([
            'error' => 'Failed to fetch food by ID',
            'status' => $response->status(),
            'details' => $response->body(),
        ], $response->status());
    }

    //Returns a specif food item from the usda database by upc
    public function getByUpc($upc)
    {
        $apiKey = env('FOOD_DATA_API_KEY');
        $url = "https://api.nal.usda.gov/fdc/v1/foods/search?query={$upc}&api_key={$apiKey}";

        $response = Http::get($url);

    if ($response->successful()) {
        $foods = $response->json()['foods'] ?? [];

        // Find the food with the exact UPC match
        $food = collect($foods)->firstWhere('gtinUpc', $upc);

        if ($food) {
            return response()->json($food);
        }

        return response()->json([
            'error' => 'No food found with the specified UPC',
            'status' => 404,
        ], 404);
    }

        return response()->json([
            'error' => 'Failed to fetch food by ID',
            'status' => $response->status(),
            'details' => $response->body(),
        ], $response->status());
    }

    //Returns food items from the usda database based on a query
    public function searchByQuery(Request $request)
    {

        $apiKey = env('FOOD_DATA_API_KEY');

        $query = $request->input('query');
        $pageNumber = $request->input('pageNumber',1);
        $pageSize = $request->input('pageSize', 10);
        $dataType = $request->input('dataType', 'Branded');

        $url = 'https://api.nal.usda.gov/fdc/v1/foods/search';

        $params = [
            'query' => $query,
            'dataType' => $dataType,
            'pageSize'=> $pageSize,
            'pageNumber'=> $pageNumber,
            'api_key' => $apiKey,
        ];

        $response = Http::get($url, $params);


        if($response->successful()){
            return $response->json();

        } else  {
            return response()->json([
                'error' => 'Failed to fetch food data by query',
                'status' => $response->status(),
                'details' => $response->body(),
            ], $response->status());
        }
    }
}
