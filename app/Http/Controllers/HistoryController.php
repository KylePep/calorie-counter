<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HistoryController extends Controller
{
    public function index()
    {

        $user = User::find(Auth::id());

        $account = $user->account;

        $calorieDays = $user->calorieDays() 
        ->orderBy('created_at', 'desc') 
        ->get();

        // Decode food_items for each CalorieDay in the collection
        $calorieDays->transform(function ($calorieDay) {
            $calorieDay->food_items = json_decode($calorieDay->food_items, true);
            return $calorieDay;
        });

        return Inertia::render('History', [
            'account' => $account,
            'calorieDays' => $calorieDays,
        ]);
        
    }
}
