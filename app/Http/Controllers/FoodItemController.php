<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFoodItemRequest;
use App\Http\Requests\UpdateFoodItemRequest;
use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FoodItemController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());

        $account = $user->account;


        $groupedFoodItems = $user->foodItems->sortByDesc('created_at')->groupBy(function ($item) {
            return $item->fdcId ? 'with_fdcId' : 'without_fdcId';
        });

        foreach($groupedFoodItems as $group => $items){
            foreach($items as $item){
                $item->foodNutrients = $item->foodNutrients;
            }
        }

        return Inertia::render('Food', [
            'status' => session('status'),
            'account' => $account,
            'with_fdcId' => $groupedFoodItems->get('with_fdcId', []), 
            'without_fdcId' => $groupedFoodItems->get('without_fdcId', [])
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
            'foodNutrients' => ['nullable'],
            'ingredients' => ['nullable'], 
        ]);

        $foodItem = $user->foodItems()->create([
            'fdcId' => $attributes['fdcId'],
            'description' => $attributes['description'],
            'brandName' => $attributes['brandName'] ?? 'N/A',
            'brandOwner' => $attributes['brandOwner'] ?? 'N/A',
            'servingSize' => $attributes['servingSize'],
            'servingSizeUnit' => $attributes['servingSizeUnit'],
            'foodCategory' => $attributes['foodCategory'],
            'calories' => $attributes['calories'],
            'foodNutrients' => $attributes['foodNutrients'], 
            'ingredients' => $attributes['ingredients'] 
        ]);

        return back()->with([
            'success' => 'Food item created successfully!',
            'foodItem' => $foodItem,
        ]);
    }

    public function update(UpdateFoodItemRequest $request, FoodItem $foodItem)
    {
        $attributes = $request->validate([
            'fdcId' => ['nullable'],
            'description' => ['required'],
            'brandName' => ['nullable'],
            'brandOwner' => ['nullable'],
            'servingSize' => ['required'],
            'servingSizeUnit' => ['required'],
            'foodCategory' => ['required'],
            'calories' => ['required'],
            'foodNutrients' => ['nullable'], 
            'ingredients' => ['nullable'],
        ]);

        $foodItem->update([
            'fdcId' => $attributes['fdcId'],
            'description' => $attributes['description'],
            'brandName' => $attributes['brandName'] ?? 'N/A',
            'brandOwner' => $attributes['brandOwner'] ?? 'N/A',
            'servingSize' => $attributes['servingSize'],
            'servingSizeUnit' => $attributes['servingSizeUnit'],
            'foodCategory' => $attributes['foodCategory'],
            'calories' => $attributes['calories'],
            'foodNutrients' => $attributes['foodNutrients'], 
            'ingredients' => $attributes['ingredients']
        ]);

        return back()->with([
            'success' => 'Food item updated successfully!',
            'foodItem' => $foodItem,
        ]);
    }

    public function destroy( FoodItem $foodItem)
    {
        $user = User::find(Auth::id());

        if($user->foodItems()->where('id', $foodItem->id)->exists()){
            $foodItem->delete();
        } 
        return redirect()->back();
    }
}
