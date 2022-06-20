<?php


namespace Jhavenz\PermissionName\Facades;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Jhavenz\PermissionName\Adapters\AllPermissionsAdapter;

/**
 * Class AllPermissions
 * @package Jhavenz\PermissionName\Facades
 *
 * @see \Jhavenz\PermissionName\PermissionManager::class
 *
 * @see \Jhavenz\PermissionName\PermissionManager::all()
 * @method static Collection all()
 *
 * @see \Jhavenz\PermissionName\Adapters\AllPermissionsAdapter::setOwnershipType()
 * @method static AllPermissionsAdapter setScope(string $ownershipType)
 *
 * @see \Jhavenz\PermissionName\Adapters\AllPermissionsAdapter::forOwned()
 * @method static AllPermissionsAdapter forOwned()
 *
 * @see \Jhavenz\PermissionName\Adapters\AllPermissionsAdapter::forOwnedSetting()
 * @method static AllPermissionsAdapter forOwnedSetting()
 *
 * @see \Jhavenz\PermissionName\Adapters\AllPermissionsAdapter::forTeam()
 * @method static AllPermissionsAdapter forTeam()
 *
 * @see \Jhavenz\PermissionName\Adapters\AllPermissionsAdapter::forTeamSetting()
 * @method static AllPermissionsAdapter forTeamSetting()
 */
class AllPermissions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AllPermissions';
    }
}
