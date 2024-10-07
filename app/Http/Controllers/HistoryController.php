<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HistoryController extends Controller
{
    public function index() //TODO - This creates a resource, calorieDay, that isn't a 'dashboard', fix that
    {

        $user = User::find(Auth::id());

        $account = $user->account;

        $calorieDays = $user->calorieDays() 
        ->orderBy('created_at', 'desc') 
        ->get();

        return Inertia::render('History', [
            'account' => $account,
            'calorieDays' => $calorieDays,
        ]);
        
    }
}
