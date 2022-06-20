<?php


namespace Jhavenz\PermissionName\Factories;


use Jhavenz\PermissionName\Adapters\OwnedPermissionsAdapter;
use Jhavenz\PermissionName\Adapters\OwnedSettingPermissionsAdapter;
use Jhavenz\PermissionName\Adapters\TeamPermissionsAdapter;
use Jhavenz\PermissionName\Adapters\TeamSettingPermissionsAdapter;
use Jhavenz\PermissionName\Exceptions\PermissionLookupException;
use Jhavenz\PermissionName\PermissionGenerator;

class AllPermissions
{
    public static function makeAdapter($scopeType)
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
