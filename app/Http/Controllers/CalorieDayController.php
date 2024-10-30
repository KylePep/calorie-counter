<?php

namespace App\Http\Controllers;

use App\Models\CalorieDay;
use App\Http\Requests\StoreCalorieDayRequest;
use App\Http\Requests\UpdateCalorieDayRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

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

        $user = User::find(Auth::id());

        $account = $user->account;


        $calorieDay->food_items = json_decode($calorieDay->food_items, true);

        $groupedFoodItems = $user->foodItems->sortByDesc('created_at')->groupBy(function ($item) {
            return $item->fdcId ? 'with_fdcId' : 'without_fdcId';
        });

        foreach($groupedFoodItems as $group => $items){
            foreach($items as $item){
                $item->foodNutrients = json_decode($item->foodNutrients, true);
            }
        }

        $incompleteCarrots = $user->carrots->groupBy(function($carrot){
            return $carrot->complete ? 'complete' : 'incomplete';
        });

        return Inertia::render('CalorieDay', [
            'account' => $account,
            'calorieDay' => $calorieDay,
            'with_fdcId' => $groupedFoodItems->get('with_fdcId', []),
            'without_fdcId' => $groupedFoodItems->get('without_fdcId', []),
            'carrots' => $incompleteCarrots->get('incomplete',[]),
        ]);
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
            'journal' => ['string'],
            'food_items'=> ['array'],
        ]);

        $calorieDay->goal = $validated['goal'] ?? $calorieDay->goal;
        
        $calorieDay->journal = $validated['journal'] ?? $calorieDay->journal;

        $existingFoodItems = json_decode($calorieDay->food_items, true) ?? [];

        if ($request->remove && isset($validated['food_items'])) {
            
            $existingFoodItems = json_decode($calorieDay->food_items, true) ?? [];

            
            if (!empty($existingFoodItems)) {
                
                $itemToRemove = $validated['food_items'][0];
                $itemFound = false; 

                // Find and remove the matching item
                foreach ($existingFoodItems as $index => $item) {
                    if (
                        isset($item['description'], $itemToRemove['description']) &&
                        $item['description'] === $itemToRemove['description'] 
                    ) {
                        // Remove the item from the array
                        unset($existingFoodItems[$index]);
                        $itemFound = true; // Set flag to true when item is found
                        break; // Stop after removing the first match
                    }
                }

                if (!$itemFound) {
                    
                    return response()->json([
                        'error' => 'Food item not found for removal.',
                    ], 404);
                }
    
                // Re-index the array to maintain correct indexes after removal
                $existingFoodItems = array_values($existingFoodItems);
            }
    
            // Re-encode back to JSON
            $calorieDay->food_items = json_encode($existingFoodItems);
            $calorieDay->count -= $validated['count'] ?? 0;
        } else {
            $calorieDay->food_items = json_encode(array_merge($existingFoodItems, $validated['food_items']));
            $calorieDay->count += $validated['count'] ?? 0;
        }


        $calorieDay->save();
        $calorieDay->food_items = json_decode($calorieDay->food_items, true);
        return $calorieDay;

    }

    public function patch(UpdateCalorieDayRequest $request, CalorieDay $calorieDay)
    {

        $attributes = $request->validate([
            'goal' => ['integer', 'nullable'],
            'journal' => ['string', 'nullable'],
        ]);

        $filteredAttributes = array_filter($attributes, fn($value)=> !is_null($value));

        $calorieDay->update($filteredAttributes);

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CalorieDay $calorieDay)
    {
        //
    }
}
