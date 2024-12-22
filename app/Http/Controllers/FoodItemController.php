<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFoodItemRequest;
use App\Http\Requests\UpdateFoodItemRequest;
use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
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

        $user = User::find(Auth::id());

        $query = $request->input('query');
        $pageNumber = $request->input('pageNumber',1);
        $pageSize = $request->input('pageSize', 10);
        $dataType = $request->input('dataType', 'Branded');

        $foodItems = FoodItem::with(['user'])
        ->where('description', 'LIKE', '%'.$query.'%')
        ->whereColumn('user_id', 'creator_id')
        ->where('user_id', '!=', $user->id)
        ->get();

        return $foodItems;
    }

    public function ratio(Request $request)
        {
            $user = Auth::user(); 
            $goal = $user->account->goal ?? 2000; 

            $ranges = $request->input('ranges');

            // Initialize an empty collection to store results
            $filteredFoodItemsByCategory = [];

            // Define the categories
            $categories = ['breakfast', 'lunch', 'dinner', 'snack', 'beverage'];

            foreach ($categories as $category) {
                if (isset($ranges[$category])) {
                    $rangePercentage = $ranges[$category] / 100;

                    $foodItems = FoodItem::with('user')
                        ->whereColumn('user_id', 'creator_id')
                        ->where('user_id', '!=', $user->id)
                        ->where('foodCategory', $category)
                        ->whereRaw('ABS(calories - ?) < ?', [
                            $goal * $rangePercentage,
                            100, // Threshold to determine "close to goal" (adjust as needed)
                        ])
                        ->get();

                      // Store the items under the corresponding category key
            $filteredFoodItemsByCategory[$category] = $foodItems;
        } else {
            // Ensure all categories are included in the response, even if empty
            $filteredFoodItemsByCategory[$category] = [];
        }
    }
            return response()->json($filteredFoodItemsByCategory);
        }


    public function store(StoreFoodItemRequest $request)
    {
        $user = User::find(Auth::id());
    
        $validated = $request->validate([
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
            'photo' => [ 'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_string($value) && !($value instanceof UploadedFile)) {
                        $fail('The '.$attribute.' must either be a string or file.');
                    }
                }
            ],
            'creator_id' => ['nullable']
        ]);

        if (is_null($request->creator_id)){
            $validated['creator_id'] = $user->id;
        }

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');
            $fileName = $file->getClientOriginalName();

            $stream = fopen($file->getRealPath(), 'r');

            Storage::disk('gcs')->writeStream($fileName, $stream);

            $photoPath = Storage::disk('gcs')->publicUrl($fileName);           
        } elseif (is_string($request->photo)) {
            $photoPath = $validated['photo']; // Treat as a URL
        } else {
            $photoPath = null;
        }

        $foodItem = $user->foodItems()->create([
            'fdcId' => $validated['fdcId'],
            'description' => $validated['description'],
            'brandName' => $validated['brandName'] ?? 'N/A',
            'brandOwner' => $validated['brandOwner'] ?? 'N/A',
            'servingSize' => $validated['servingSize'],
            'servingSizeUnit' => $validated['servingSizeUnit'],
            'foodCategory' => $validated['foodCategory'],
            'calories' => $validated['calories'],
            'foodNutrients' => $validated['foodNutrients'], 
            'ingredients' => $validated['ingredients'],
            'photo' => $photoPath,
            'creator_id' => $validated['creator_id'],
        ]);

        return back()->with([
            'success' => 'Food item created successfully!',
            'foodItem' => $foodItem,
        ]);
    }

    public function update(UpdateFoodItemRequest $request, FoodItem $foodItem)
    {
        $user = User::find(Auth::id());

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
            'photo' => [ 'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_string($value) && !($value instanceof UploadedFile)) {
                        $fail('The '.$attribute.' must either be a string or file.');
                    }
                }
            ]
        ]);

        if (is_null($request->creator_id)){
            $attributes['creator_id'] = $user->id;
        }

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');

            $fileName = $file->getClientOriginalName();

            $stream = fopen($file->getRealPath(), 'r');

            Storage::disk('gcs')->writeStream($fileName, $stream);

            $photoPath = Storage::disk('gcs')->publicUrl($fileName);           
        } elseif (is_string($request->photo)) {
            $photoPath = $attributes['photo']; // Treat as a URL
        } else {
            $photoPath = null;
        }

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
            'photo' => $photoPath,
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

            // if(!empty($foodItem->photo) && $foodItem ->creator_id == $user->id ){
            //     $photoPath = parse_url($foodItem->photo, PHP_URL_PATH);
            //     $photoPath = ltrim($photoPath, '/caloriecounter/');
            //     Storage::disk('gcs')->delete($photoPath);
            // }

            $foodItem->delete();
        } 
        return redirect()->back();
    }
}
