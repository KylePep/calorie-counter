<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFoodItemRequest;
use App\Http\Requests\UpdateFoodItemRequest;
use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
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

    public function search(Request $request)
    {

        $query = $request->input('query');
        $pageNumber = $request->input('pageNumber',1);
        $pageSize = $request->input('pageSize', 10);
        $dataType = $request->input('dataType', 'Branded');

        $foodItems = FoodItem::with(['user'])
        ->where('description', 'LIKE', '%'.$query.'%')
        ->get();

        return $foodItems;
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
            'photo' => ['nullable', File::types(['png','jpg','webp'])]
        ]);

        if ($request->hasFile('photo')){
            $photoPath = $request->file('photo')->store('photos','public');
        } else {
            $photoPath = null;
        }

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
            'ingredients' => $attributes['ingredients'],
            'photo' => $photoPath
        ]);

        return back()->with([
            'success' => 'Food item created successfully!',
            'foodItem' => $foodItem,
        ]);
    }

    public function update(UpdateFoodItemRequest $request, FoodItem $foodItem)
    {

        Gate::authorize('update', $foodItem);

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
            'photo' => ['nullable']
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
            'ingredients' => $attributes['ingredients'],
            'photo' => $attributes['photo'],
        ]);

        return back()->with([
            'success' => 'Food item updated successfully!',
            'foodItem' => $foodItem,
        ]);
    }

    public function destroy( FoodItem $foodItem)
    {

        Gate::authorize('delete', $foodItem);

        $user = User::find(Auth::id());

        if($user->foodItems()->where('id', $foodItem->id)->exists()){
            $foodItem->delete();
        } 
        return redirect()->back();
    }
}
