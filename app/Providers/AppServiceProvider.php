<?php

namespace App\Providers;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;

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
        // Register the GCS driver
        Storage::extend('gcs', function ($app, $config) {
            $storageClient = new StorageClient([
                'projectId' => $config['project_id'],
                'keyFilePath' => $config['key_file'],
            ]);

            $bucket = $storageClient->bucket($config['bucket']);

            $adapter = new GoogleCloudStorageAdapter($bucket);

            return new \Illuminate\Filesystem\Filesystem(new \League\Flysystem\Filesystem($adapter));
        });

        Vite::prefetch(concurrency: 3);

        Model::unguard();
    }
}
