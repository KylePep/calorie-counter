<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
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
        if (env('GOOGLE_CONFIG')) {
            $keyFilePath = storage_path('app/google-credentials-heroku.json');
            file_put_contents($keyFilePath, env('GOOGLE_CONFIG'));
        }

        Vite::prefetch(concurrency: 3);

        Model::unguard();
    }
}
