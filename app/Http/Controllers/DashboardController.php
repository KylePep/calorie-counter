<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{

    //GetorCreate CalorieDay 

    public function index()
    {
        $user = User::find(Auth::id());

        $account = $user->account;

        $today = Carbon::today();

        $CalorieDay = $user->calorieDays() 
            ->whereDate('created_at', $today)
            ->first();

            
            if (!$CalorieDay){
                $CalorieDay = $user->calorieDays()->create([
                    'goal' => $account->goal ?? 2000,
                    'count' => 0,
                    'user_id' => $user->id,
                    'food_items' => json_encode([]) // Convert array to JSON
                ]);
            }

            $groupedFoodItems = $user->foodItems->groupBy(function ($item) {
                return $item->fdcId ? 'with_fdcId' : 'without_fdcId';
            });
        
        return Inertia::render('Dashboard', [
            'account' => $account,
            'calorieDay' => $CalorieDay,
            'with_fdcId' => $groupedFoodItems->get('with_fdcId', []),
            'without_fdcId' => $groupedFoodItems->get('without_fdcId', []),
        ]);
    }
}
