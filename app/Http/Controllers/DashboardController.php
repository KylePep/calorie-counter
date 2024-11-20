<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{

    public function index() 
    {
        $user = User::with(['foodItems', 'carrots'])->find(Auth::id());

        $account = $user->account;
        if(!$account){
            return Inertia::render('Dashboard', [
                'account' => $account,
                'calorieDay' => [],
                'foodItems' => [],
                'with_fdcId' => [],
                'without_fdcId' => [],
            ]);
        } else {

            $userTimezone = $account->timezone;
    
            // Get today's date in the user's timezone
            $today = Carbon::now($userTimezone)->startOfDay();
    
            // Retrieve all calorie days and manually filter by user's timezone
            $CalorieDay = $user->calorieDays->filter(function ($calorieDay) use ($today, $userTimezone) {
                $createdAt = Carbon::parse($calorieDay->created_at)->setTimezone($userTimezone)->startOfDay();
                return $createdAt->equalTo($today);
            })->first();
        
                
                if (!$CalorieDay){
                    $CalorieDay = $user->calorieDays()->create([
                        'goal' => $account->goal ?? 2000,
                        'bmr' => $account->bmr ?? 2000,
                        'count' => 0,
                        'user_id' => $user->id,
                        'food_items' => [],
                        'created_at' => $today->setTimezone('UTC')
                    ]);
                } 

                $foodItems = $user->foodItems;
                

                $sortedCarrots = $user->carrots->groupBy(function($carrot){
                    return $carrot->complete ? 'complete' : 'incomplete';
                });

                
                // Retrieve all weighIns and manually filter by user's timezone
                $weighIn = $user->weigh_ins->filter(function ($weighIn) use ($today, $userTimezone) {
                    
                    $createdAt = Carbon::parse($weighIn->created_at)
                    ->setTimezone($userTimezone)
                    ->startOfDay();
                    
                    return $createdAt->equalTo($today);
                })->first();

                if(isset($weighIn, $sortedCarrots['incomplete'])){
                    foreach($sortedCarrots['incomplete'] as $item){
                        if($item['category'] == 'weightLoss' || $item['category'] == 'weightGain'){
                            $item['currentValue'] = $weighIn['weight'];
                        }
                    }
                    unset($item);
                }

                return Inertia::render('Dashboard', [
                    'account' => $account,
                    'calorieDay' => $CalorieDay,
                    'foodItems' => $foodItems,
                    'carrots' => $sortedCarrots,
                    'weighIn' => $weighIn
                ]);
        }
        
    }
}
