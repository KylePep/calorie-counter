<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFoodItemRequest;
use App\Http\Requests\UpdateFoodItemRequest;
use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
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
                $item->foodNutrients = json_decode($item->foodNutrients, true);
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
            'foodNutrients' => ['nullable'], //array
            'ingredients' => ['nullable'], //array
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
            'foodNutrients' => json_encode($attributes['foodNutrients']), // Convert array to JSON
            'ingredients' => json_encode($attributes['ingredients']) //This is needs to be a string
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
            'foodNutrients' => ['nullable'], //array
            'ingredients' => ['nullable'], //array
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
            'foodNutrients' => json_encode($attributes['foodNutrients']), // Convert array to JSON
            'ingredients' => $attributes['ingredients'] //This is needs to be a string
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
