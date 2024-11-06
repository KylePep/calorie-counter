<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HistoryController extends Controller
{
    public function show()
    {

        $user = User::find(Auth::id());

        $account = $user->account;

        $calorieDays = $user->calorieDays() 
        ->orderBy('created_at', 'desc')
        ->take(31)
        ->get();

        // Decode food_items for each CalorieDay in the collection
        $calorieDays->transform(function ($calorieDay) {
            $calorieDay->food_items = json_decode($calorieDay->food_items, true);
            return $calorieDay;
        });

        $weighIns = $user->weigh_ins()
        ->orderBy('created_at', 'desc')
        ->take(31)
        ->get();

        return Inertia::render('History/Show', [
            'account' => $account,
            'calorieDays' => $calorieDays,
            'weighIns' => $weighIns
        ]);
        
    }

    public function searchHistory(Request $request)
    {

        $user = User::find(Auth::id());

        $account = $user->account;

        $validated = $request->validate([
            'day'=> ['string', 'nullable'],
            'month'=> ['string', 'nullable'],
        ]);

        $weighInQuery = $user->weigh_ins()
        ->orderBy('created_at', 'desc');

        $calorieDaysQuery = $user->calorieDays()
        ->orderBy('created_at', 'desc');
        $results = ['Last 31 Results'];

        if (!empty($validated['day'])){
            $calorieDaysQuery->whereDate('created_at', Carbon::parse($validated['day']));
            $weighInQuery->whereDate('created_at', Carbon::parse($validated['day']));
            $results = [Carbon::parse($validated['day'])->format('m-d-Y')];
        }

        elseif (!empty($validated['month'])){
            $monthStart = Carbon::parse($validated['month'])->startOfMonth();
            $monthEnd = Carbon::parse($validated['month'])->endOfMonth();
            $calorieDaysQuery->whereBetween('created_at', [$monthStart, $monthEnd]);
            $weighInQuery->whereBetween('created_at', [$monthStart, $monthEnd]);
            $parsedMonthStart = Carbon::parse($monthStart)->format('m-d-Y');
            $parsedMonthEnd = Carbon::parse($monthEnd)->format('m-d-Y');

            $results = [$parsedMonthStart, $parsedMonthEnd];
        }

        else {
            $calorieDaysQuery->take(31);
            $weighInQuery->take(31);
        }

        $calorieDays = $calorieDaysQuery->get();
        $weighIns = $weighInQuery->get();

        // Decode food_items for each CalorieDay in the collection
        $calorieDays->transform(function ($calorieDay) {
            $calorieDay->food_items = json_decode($calorieDay->food_items, true);
            return $calorieDay;
        });

        

        return Inertia::render('History/Show', [
            'account' => $account,
            'calorieDays' => $calorieDays,
            'results' => $results,
            'weighIns' => $weighIns
        ]);

    }
}
