<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FoodDataController extends Controller
{
    public function getFoodData(Request $request)
    {

        $apiKey = env('FOOD_DATA_API_KEY');

        $query = $request->input('query');

        $url = 'https://api.nal.usda.gov/fdc/v1/foods/search';

        $params = [
            'query' => $query,
            'dataType' => 'Branded',
            'api_key' => $apiKey,
        ];

        $response = Http::get($url, $params);


        if($response->successful()){
            return $response->json();
        } else  {
            // Get the status code and response body for more details
            $statusCode = $response->status();
            $errorBody = $response->body(); // or use $response->json() if the error response is in JSON format

            // Optionally, you can log the error for further analysis
            // \Log::error('Food Data API request failed', [
            //     'status' => $statusCode,
            //     'response' => $errorBody,
            // ]);

            // Return a more detailed error response to the frontend
            return response()->json([
                'error' => 'Failed to fetch Food Data',
                'status' => $statusCode,
                'details' => $errorBody,
            ], $statusCode);
        }
    }
}
