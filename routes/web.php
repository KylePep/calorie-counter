<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\FoodDataController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
})->name('welcome');

Route::get('/food-data', FoodDataController::class);

Route::get('/calculator', function () { //TODO - Move to CalculatorController

    $user = Auth::user();

    $account = $user ? $user->account : [
        'gender' => 'Male',
        'weight' => 160,
        'height' => 177.8, 
        'age' => 25,
        'activity' => '1.55',
        'goal' => 2000,
    ];
    return Inertia::render('Calculator', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
            'account' => $account,
    ]);
})->name('calculator');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function(){
    Route::get('/food', [FoodController::class, 'index'])->name('food');
});


Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/account', [AccountController::class, 'store'])->name('account.store');
    Route::put('/account/{account}', [AccountController::class, 'update'])->name('account.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
