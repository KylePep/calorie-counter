<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Http\Requests\StoreFoodItemRequest;
use App\Http\Requests\UpdateFoodItemRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FoodItemController extends Controller
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
    public function store(StoreFoodItemRequest $request)
    {
        $user = User::find(Auth::id());
        
        // $attributes = $request->validate([
        //     'title' => ['required'],
        //     'salary' => ['required'],
        //     'location' => ['required'],
        //     'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
        //     'url' => ['required', 'active_url'],
        //     'tags' => ['nullable'],
        // ]);

        // $attributes['featured'] = $request->has('featured');

        // $job = Auth::user()->employer->jobs()->create(Arr::except($attributes, 'tags'));

        // if ($attributes['tags'] ?? false) {
        //     foreach (explode(',', $attributes['tags']) as $tag) {
        //         $job->tag($tag);
        //     }
        // }

        // return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(FoodItem $foodItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FoodItem $foodItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodItemRequest $request, FoodItem $foodItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FoodItem $foodItem)
    {
        //
    }
}
