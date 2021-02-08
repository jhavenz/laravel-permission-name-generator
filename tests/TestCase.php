<?php

namespace Sourcefli\PermissionName\Tests;

use Illuminate\Support\Str;
use Sourcefli\PermissionName\Factories\PermissionNameFactory;
use Sourcefli\PermissionName\PermissionNameServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{

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

    protected function ownershipTypeCount ()
    {
        return count($this->ownershipTypes());
    }

    protected function ownershipTypes ()
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

    protected function totalPermissionsForOneOwnershipType (string $ownershipType_ = 'owned') //doc var
    {
        return $this->accessLevelCount()
            * $this->resourceCount();
    }
}
