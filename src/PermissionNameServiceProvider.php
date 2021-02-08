<?php

namespace Sourcefli\PermissionName;

use Illuminate\Support\ServiceProvider;
use Sourcefli\PermissionName\Adapters\AllPermissionsAdapter;
use Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter;
use Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter;
use Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter;
use Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter;

class PermissionNameServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/permission-name.php', 'permission-name');

        $this->app->singleton('AllPermissions', function () {
            return new AllPermissionsAdapter;
        });

        $this->app->singleton('OwnedPermission', function () {
            return new OwnedPermissionsAdapter;
        });

        $this->app->singleton('TeamPermission', function () {
            return new TeamPermissionsAdapter;
        });

        $this->app->singleton('TeamSettingPermission', function () {
            return new TeamSettingPermissionsAdapter;
        });

        $this->app->singleton('OwnedSettingPermission', function () {
            return new OwnedSettingPermissionsAdapter;
        });

    }

    public function boot()
    {

    }
}
