<?php


namespace Sourcefli\PermissionName\Facades;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Sourcefli\PermissionName\Adapters\AllPermissionsAdapter;

/**
 * Class AllPermissions
 * @package Sourcefli\PermissionName\Facades
 *
 * @see \Sourcefli\PermissionName\PermissionManager::class
 *
 * @see \Sourcefli\PermissionName\PermissionManager::all()
 * @method static Collection all()
 *
 * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::setOwnershipType()
 * @method static AllPermissionsAdapter setScope(string $ownershipType)
 *
 * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::forOwned()
 * @method static AllPermissionsAdapter forOwned()
 *
 * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::forOwnedSetting()
 * @method static AllPermissionsAdapter forOwnedSetting()
 *
 * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::forTeam()
 * @method static AllPermissionsAdapter forTeam()
 *
 * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::forTeamSetting()
 * @method static AllPermissionsAdapter forTeamSetting()
 */
class AllPermissions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AllPermissions';
    }
}