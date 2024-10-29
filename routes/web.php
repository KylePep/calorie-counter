<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\CalorieDayController;
use App\Http\Controllers\CarrotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\FoodDataController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])
    ->name('welcome');

Route::get('/foodData/{id}', [FoodDataController::class, 'getById']);
Route::get('/search-foodData', [FoodDataController::class, 'searchByQuery']);

Route::get('/calculator', [CalculatorController::class, 'create'])->name('calculator');


Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['verified'])
        ->name('dashboard');

    Route::get('/history', [HistoryController::class, 'index'])
        ->name('history');
    
    Route::get('/food', [FoodController::class, 'index'])->name('food.index');
    Route::post('/food', [FoodController::class, 'store'])->name('food.store');
    Route::put('/food/{foodItem}', [FoodController::class, 'update'])->name('food.update');
    Route::delete('/food/{foodItem}', [FoodController::class, 'destroy'])->name('food.destroy');

    Route::get('/calorie-day/{calorieDay}', [CalorieDayController::class, 'show'])->name('calorieDay.show');
    Route::put('/calorie-day/{calorieDay}', [CalorieDayController::class, 'update'])->name('calorieDay.update');

    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::post('/account', [AccountController::class, 'store'])->name('account.store');
    Route::put('/account/{account}', [AccountController::class, 'update'])->name('account.update');


    Route::post('/carrot', [CarrotController::class, 'store'])->name('carrot.store');
    Route::put('/carrot/{carrot}', [CarrotController::class, 'update'])->name('carrot.update');
    Route::delete('/carrot/{carrot}', [CarrotController::class, 'destroy'])->name('carrot.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
