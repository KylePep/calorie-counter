<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFoodItemRequest;
use App\Http\Requests\UpdateFoodItemRequest;
use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FoodController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());

        $foodItems = $user->foodItems;

        return Inertia::render('Food', [
            'status' => session('status'),
            'foodItems' => $foodItems,
        ]);
    }

    public function store(StoreFoodItemRequest $request)
    {
        $user = User::find(Auth::id());
    
        $attributes = $request->validate([
            'fdcId' => ['nullable'],
            'description' => ['required'],
            'brandName' => ['nullable'],
            'brandOwner' => ['nullable'],
            'servingSize' => ['required'],
            'servingSizeUnit' => ['required'],
            'foodCategory' => ['required'],
            'calories' => ['required'],
            'foodNutrients' => ['nullable'], //array
            'ingredients' => ['nullable'], //array
        ]);

        $user->foodItems()->create([
            'fdcId' => $attributes['fdcId'],
            'description' => $attributes['description'],
            'brandName' => $attributes['brandName'],
            'brandOwner' => $attributes['brandOwner'],
            'servingSize' => $attributes['servingSize'],
            'servingSizeUnit' => $attributes['servingSizeUnit'],
            'foodCategory' => $attributes['foodCategory'],
            'calories' => $attributes['calories'],
            'foodNutrients' => json_encode($attributes['foodNutrients']), // Convert array to JSON
            'ingredients' => json_encode($attributes['ingredients']) // Convert array to JSON
        ]);

        return redirect('/food');
    }

    public function update(UpdateFoodItemRequest $request, FoodItem $foodItem)
    {
        //
    }
}
