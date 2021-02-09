<?php

namespace Sourcefli\PermissionName\Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Sourcefli\PermissionName\Factories\PermissionNameFactory;
use Sourcefli\PermissionName\PermissionNameServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /** @var string */
    protected string $resource;

    /** @var string */
    protected string $settingsResource;

    protected function setUp (): void
    {
        parent::setUp();

        $this->clearConfigFor('permission-name.resources');
        $this->clearConfigFor('permission-name.settings');

        Config::set('permission-name.resources', [
            'user',
            'billing',
            'tenant',
            'agent',
            'manager'
        ]);

        Config::set('permission-name.settings', [
            'email',
            'profile',
            'phone_numbers',
            'appointments',
            'addresses',
            'manager'
        ]);

        $resource = config('permission-name.resources');
        $idx = array_rand($resource);
        $this->resource = $resource[$idx];

        $settings = config('permission-name.settings');
        $idx = array_rand($settings);
        $this->settingsResource = $settings[$idx];
    }

    protected function getPackageProviders($app)
    {
        return [
            PermissionNameServiceProvider::class
        ];
    }

//    protected function getEnvironmentSetUp($app)
//    {
//        // perform environment setup
//    }

    protected function clearConfigFor(string $configPath)
    {
        Config::set($configPath, []);
    }

    protected function allUserResources ()
    {
        return config('permission-name.resources');
    }

    protected function accessLevelCount ()
    {
        return count(PermissionNameFactory::allAccessLevels());
    }

    protected function resourceCount ()
    {
        return count(config('permission-name.resources'));
    }

    protected function settingsResourcesCount ()
    {
        return count(config('permission-name.settings'));
    }

    protected function resourcePlusSettingsCount ()
    {
        return count(array_merge(
            config('permission-name.resources'),
            config('permission-name.settings')
        ));
    }

    protected function basicScopes ()
    {
        return [
            'OwnedPermissions', 'TeamPermissions'
        ];
    }

    protected function settingScopes ()
    {
        return [
            'OwnedSettingPermissions', 'TeamSettingPermissions'
        ];
    }

    protected function basicScopesCount (): int
    {
        return count($this->basicScopes());
    }

    protected function settingScopesCount (): int
    {
        return count($this->settingScopes());
    }

    protected function scopesCount ()
    {
        return count($this->scopeTypes());
    }

    protected function scopeTypes ()
    {
        return [
            //not configurable for the time being, always 4
            'OwnedPermissions', 'OwnedSettingPermissions',
            'TeamPermissions', 'TeamSettingPermissions'
        ];
    }

    /**
     * From 'user.owned.browse' (the full permission name)
     * To 'user' (as defined in config)
     * @param $permission
     * @return string
     */
    protected function extractResourceNameFromPermission ($permission)
    {
        return Str::startsWith($permission, '_setting')
            ? (string) Str::of($permission)->after('_setting.')->before('.')
            : Str::before($permission, '.');
    }

    protected function totalPermissionsForOneScope (string $ownershipType_ = 'owned') //doc var
    {
        return $this->accessLevelCount()
            * $this->resourceCount();
    }
}
