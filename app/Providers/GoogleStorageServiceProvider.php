<?php 

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;

class GoogleStorageServiceProvider extends ServiceProvider {
  
    public function boot()
    {
      Storage::extend('gcs', function ($app, $config) 
      {
        $storageClient = new StorageClient([
            'projectId' => $config['project_id'],
            'keyFilePath' => $config['key_file'],
        ]);

        $bucket = $storageClient->bucket($config['bucket']);

        $adapter = new GoogleCloudStorageAdapter($bucket);

        return new Filesystem($adapter);
      });
    }

    public function register()
    {
        //
    }

}