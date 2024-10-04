<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FoodDataController extends Controller
{
    public function __invoke(Request $request)
    {


        $apiKey = env('FOOD_DATA_API_KEY');

        $query = $request->input('query');
        $pageNumber = $request->input('pageNumber',1);
        $pageSize = $request->input('pageSize', 10);

        $url = 'https://api.nal.usda.gov/fdc/v1/foods/search';

        $params = [
            'query' => $query,
            'dataType' => 'Branded',
            'pageSize'=> $pageSize,
            'pageNumber'=> $pageNumber,
            'api_key' => $apiKey,
        ];

        $response = Http::get($url, $params);


        if($response->successful()){
            return $response->json();

        } else  {
            $statusCode = $response->status();
            $errorBody = $response->body(); 
            return response()->json([
                'error' => 'Failed to fetch Food Data',
                'status' => $statusCode,
                'details' => $errorBody,
            ], $statusCode);
        }
    }
}
