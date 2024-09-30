<?php

namespace App\Http\Controllers;

use App\Models\CalorieDay;
use App\Http\Requests\StoreCalorieDayRequest;
use App\Http\Requests\UpdateCalorieDayRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class CalorieDayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CalorieDay $calorieDay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CalorieDay $calorieDay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCalorieDayRequest $request, CalorieDay $calorieDay)
    {

        $validated = $request->validate([
            'goal' => ['integer'],
            'count' => ['integer'],
            'food_items'=> ['array'],
        ]);

        $calorieDay->goal = $validated['goal'] ?? $calorieDay->goal;
        $calorieDay->count += $validated['count'] ?? 0;

        $existingFoodItems = json_decode($calorieDay->food_items,true) ?? [];
        $calorieDay->food_items = json_encode(array_merge($existingFoodItems, $validated['food_items']));

        return $calorieDay;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CalorieDay $calorieDay)
    {
        //
    }
}
