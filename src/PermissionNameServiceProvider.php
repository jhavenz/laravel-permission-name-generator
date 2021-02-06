<?php

namespace Sourcefli\PermissionName;

use Illuminate\Support\ServiceProvider;
use Sourcefli\PermissionName\PermissionName as PermissionNameManager;

class PermissionNameServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/permission-name.php', 'permission-name');

        $this->app->singleton('OwnedPermission', function () {
            return new PermissionNameManager;
        });

        //TODO...
//        $this->app->singleton('TeamPermissions', function () {
//            return new PermissionLookupManager('team');
//        });
//
//        $this->app->singleton('TeamPermissions', function () {
//            return new PermissionLookupManager('team');
//        });
    }

    public function boot()
    {

    }
}
