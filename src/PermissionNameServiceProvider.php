<?php

namespace Sourcefli\GetPermissionName;

use Illuminate\Support\ServiceProvider;
use Sourcefli\GetPermissionName\PermissionNameManager;

class PermissionNameServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/permission-name.php', 'permission-name');

        $this->app->bind('PermissionName', function ($app) {
            return new PermissionNameManager();
        });
    }

    public function boot()
    {
        # code...
    }
}
