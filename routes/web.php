<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\CalorieDayController;
use App\Http\Controllers\CarrotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodItemController;
use App\Http\Controllers\FoodUsdaController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])
    ->name('welcome');

Route::get('/foodUsda/{id}', [FoodUsdaController::class, 'getById']);
Route::get('/search-foodUsda', [FoodUsdaController::class, 'searchByQuery']);

Route::get('/calculator', [CalculatorController::class, 'create'])->name('calculator');


Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['verified'])
        ->name('dashboard');

    Route::get('/history', [HistoryController::class, 'index'])
        ->name('history');
    
    Route::get('/foodItem', [FoodItemController::class, 'index'])->name('foodItem.index');
    Route::post('/foodItem', [FoodItemController::class, 'store'])->name('foodItem.store');
    Route::put('/foodItem/{foodItem}', [FoodItemController::class, 'update'])->name('foodItem.update');
    Route::delete('/foodItem/{foodItem}', [FoodItemController::class, 'destroy'])->name('foodItem.destroy');

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
