<?php


namespace Sourcefli\PermissionName\Facades;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * Class AllPermissions
 * @package Sourcefli\PermissionName\Facades
 *
 * @see \Sourcefli\PermissionName\PermissionGenerator::class
 *
 * @see \Sourcefli\PermissionName\PermissionGenerator::allPermissions()
 * @method static Collection allPermissions()
 */
class AllPermissions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AllPermissions';
    }
}