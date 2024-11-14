<?php

namespace App\Http\Controllers;

use App\Models\CalorieDay;
use App\Http\Requests\StoreCalorieDayRequest;
use App\Http\Requests\UpdateCalorieDayRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
    public function store(StoreCalorieDayRequest $request)
    {
        $user = User::find(Auth::id());

        $account = $user->account;

        $validated = $request->validate([
            'date' => ['string'],
        ]);

        $userTimezone = $account->timezone;
    
        // Get validated date in the user's timezone
        $givenDay = Carbon::parse($validated['date'], $userTimezone)->startOfDay()->setTimezone('UTC');

        $existCalorieDay = $user->calorieDays()
        ->whereDate('created_at', $givenDay->toDateString())
        ->exists();

        if($existCalorieDay){
            return Redirect::route('history')->withErrors(['date' => 'A calorie day already exists for the selected date.']);
        }

        $calorieDay = $user->calorieDays()->create([
            'goal' => $account->goal ?? 2000,
            'bmr' => $account->bmr ?? 2000,
            'count' => 0,
            'user_id' => $user->id,
            'food_items' => [],
            'created_at' => $givenDay
        ]);

        return Redirect::route('calorieDay.show', $calorieDay);
    }

    /**
     * Display the specified resource.
     */
    public function show(CalorieDay $calorieDay)
    {

        $user = User::find(Auth::id());

        $account = $user->account;


        $calorieDay->food_items = $calorieDay->food_items;

        $groupedFoodItems = $user->foodItems->sortByDesc('created_at')->groupBy(function ($item) {
            return $item->fdcId ? 'with_fdcId' : 'without_fdcId';
        });

        foreach($groupedFoodItems as $group => $items){
            foreach($items as $item){
                $item->foodNutrients = $item->foodNutrients;
            }
        }

        $weighIn = $user->weigh_ins()
        ->whereDate('created_at', Carbon::parse($calorieDay->created_at))
        ->first();

        return Inertia::render('CalorieDay', [
            'account' => $account,
            'calorieDay' => $calorieDay,
            'with_fdcId' => $groupedFoodItems->get('with_fdcId', []),
            'without_fdcId' => $groupedFoodItems->get('without_fdcId', []),
            'weighIn' => $weighIn,
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

        $existingFoodItems = $calorieDay->food_items ?? [];

        if ($request->remove && isset($validated['food_items'])) {
            
            $existingFoodItems = $calorieDay->food_items ?? [];

            
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
            $calorieDay->food_items = $existingFoodItems;
            $calorieDay->count -= $validated['count'] ?? 0;
        } else {
            $calorieDay->food_items = array_merge($existingFoodItems, $validated['food_items']);
            $calorieDay->count += $validated['count'] ?? 0;
        }


        $calorieDay->save();
        $calorieDay->food_items = $calorieDay->food_items;
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
