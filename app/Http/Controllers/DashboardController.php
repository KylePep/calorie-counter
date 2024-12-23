<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() 
    {
        $user = User::with(['foodItems', 'carrots'])->find(Auth::id());

        $account = $user->account;

        $calorieDay = null;
        $calorieDays = [];
        $foodItems = [];

        if($account) {

        $userTimezone = $account->timezone;
    
        // Get today's date in the user's timezone
        $today = Carbon::now($userTimezone)->startOfDay();

        $calorieDays = $user->calorieDays() 
        ->orderBy('created_at', 'desc')
        ->take(31)
        ->get();

        // Retrieve all calorie days and manually filter by user's timezone
        $calorieDay = $calorieDays->filter(function ($calorieDay) use ($today, $userTimezone) {
            $createdAt = Carbon::parse($calorieDay->created_at)->setTimezone($userTimezone)->startOfDay();
            return $createdAt->equalTo($today);
        })->first();

            $foodItems = $user->foodItems()->orderBy('created_at', 'desc')->get();
        }


        return Inertia::render('Dashboard/Index', [
            'account' => $account,
            'calorieDay' => $calorieDay ? $calorieDay : null,
            'calorieDays' => $calorieDays ? $calorieDays : [],
            'foodItems' => $foodItems ? $foodItems : [],
        ]);
    }
}
