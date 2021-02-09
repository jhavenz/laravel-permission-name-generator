<?php


namespace Sourcefli\PermissionName\Factories;


use Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter;
use Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter;
use Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter;
use Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter;
use Sourcefli\PermissionName\Exceptions\PermissionLookupException;
use Sourcefli\PermissionName\PermissionGenerator;

class AllPermissions
{
    public static function makeAdapter ($scopeType)
    {
        switch ($scopeType) {
            case PermissionGenerator::SCOPE_OWNED:
                return new OwnedPermissionsAdapter;
            case PermissionGenerator::SCOPE_TEAM:
                return new TeamPermissionsAdapter;
            case PermissionGenerator::SCOPE_OWNED_SETTING:
                return new OwnedSettingPermissionsAdapter;
            case PermissionGenerator::SCOPE_TEAM_SETTING:
                return new TeamSettingPermissionsAdapter;
            default:
                throw new PermissionLookupException("No resource scope was set when trying to call a resource method");
        }
    }
}