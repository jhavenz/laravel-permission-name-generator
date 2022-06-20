<?php

namespace Jhavenz\PermissionName;

use Illuminate\Support\ServiceProvider;
use Jhavenz\PermissionName\Adapters\AllPermissionsAdapter;
use Jhavenz\PermissionName\Adapters\OwnedPermissionsAdapter;
use Jhavenz\PermissionName\Adapters\OwnedSettingPermissionsAdapter;
use Jhavenz\PermissionName\Adapters\TeamPermissionsAdapter;
use Jhavenz\PermissionName\Adapters\TeamSettingPermissionsAdapter;

class PermissionNameServiceProvider extends ServiceProvider
{
    protected const FILENAME = Meta::CONFIG_FILENAME;
    protected const CONFIG_PATH = Meta::CONFIG_BASE_PATH;

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/' . self::FILENAME,
            self::CONFIG_PATH
        );

        $this->app->singleton('AllPermissions', function () {
            return new AllPermissionsAdapter;
        });

        $this->app->singleton('OwnedPermission', function () {
            return new OwnedPermissionsAdapter;
        });

        $this->app->singleton('OwnedSettingPermission', function () {
            return new OwnedSettingPermissionsAdapter;
        });

        $this->app->singleton('TeamPermission', function () {
            return new TeamPermissionsAdapter;
        });

        $this->app->singleton('TeamSettingPermission', function () {
            return new TeamSettingPermissionsAdapter;
        });
    }

    public function boot()
    {
        if (app()->runningInConsole()) {
            $filename = Meta::CONFIG_FILENAME;

            $this->publishes([
                __DIR__ . "/../config/" . $filename => config_path($filename),
            ]);
        }
    }
}
