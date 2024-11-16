<?php

namespace App\Providers;

use App\Models\CalorieDay;
use App\Policies\CalorieDayPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate::policy(CalorieDay::class, CalorieDayPolicy::class);

        Vite::prefetch(concurrency: 3);

        Model::unguard();
    }
}
