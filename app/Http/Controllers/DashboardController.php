<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Create an instance of ExternalDataController
        $foodDataController = new FoodDataController();
        
        // Call the method from ExternalDataController
        $foodData = $foodDataController->getFoodData();

        // Pass the data to the Inertia view
        return Inertia::render('Dashboard', [
            'foodData' => $foodData,  // Data passed to the Vue component
        ]);
    }
}
