<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class CalculatorController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        $account = $user ? $user-> account : [
            'gender' => 'Male',
            'weight' => 160,
            'height' => 177.8, 
            'age' => 25,
            'activity' => '1.55',
            'goal' => 2000,
        ];
        return Inertia::render('Calculator/Create', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'account' => $account,
        ]);
    }
}
