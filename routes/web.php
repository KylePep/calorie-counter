<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\CalorieDayController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\FoodDataController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
})->name('welcome');

Route::get('/food-data', FoodDataController::class);

Route::get('/calculator', [CalculatorController::class, 'create'])->name('calculator');


Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['verified'])
        ->name('dashboard');
    
    Route::get('/food', [FoodController::class, 'index'])->name('food.index');
    Route::post('/food', [FoodController::class, 'store'])->name('food.store');
    Route::delete('/food/{foodItem}', [FoodController::class, 'destroy'])->name('food.destroy');

    Route::put('/calorie-day/{calorieDay}', [CalorieDayController::class, 'update'])->name('calorieDay.update');

    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::post('/account', [AccountController::class, 'store'])->name('account.store');
    Route::put('/account/{account}', [AccountController::class, 'update'])->name('account.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
