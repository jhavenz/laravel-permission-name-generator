<?php


use Illuminate\Support\Collection;
use Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter;
use Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter;
use Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter;
use Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter;

if (! function_exists('teamPermission')) {
    /**
     * @param string|null $resource
     *
     * @return TeamPermissionsAdapter|Collection
     */
    function teamPermission(string $resource = null)
    {
        return $resource
            ? app('TeamPermission')->setResource($resource)
            : app('TeamPermission')->all();
    }
}


if (! function_exists('teamSettingPermission')) {
    /**
     * @param string|null $setting
     *
     * @return TeamSettingPermissionsAdapter|Collection
     */
    function teamSettingPermission(string $setting = null)
    {
        return $setting
            ? app('TeamSettingPermission')
                ->setResource($setting)
            : app('TeamSettingPermission')
                ->all();
    }
}


if (! function_exists('ownedPermission')) {
    /**
     * @param string|null $resource
     *
     * @return OwnedPermissionsAdapter|Collection
     */
    function ownedPermission(string $resource = null)
    {
        return $resource
            ? app('OwnedPermission')
                ->setResource($resource)
            : app('OwnedPermission')
                ->all();
    }
}


if (! function_exists('ownedSettingPermission')) {
    /**
     * @param string|null $setting
     *
     * @return OwnedSettingPermissionsAdapter|Collection
     */
    function ownedSettingPermission(string $setting = null)
    {
        return $setting
            ? app('OwnedSettingPermission')
                ->setResource($setting)
            : app('OwnedSettingPermission')
                ->all();
    }
}