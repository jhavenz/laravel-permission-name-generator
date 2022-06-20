<?php

namespace Jhavenz\PermissionName\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;


/**
 * Class OwnedPermission
 * @package Jhavenz\PermissionName\Facades
 *
 * @see \Jhavenz\PermissionName\PermissionGenerator::class
 *
 * @see \Jhavenz\PermissionName\PermissionGenerator::all()
 * @method static Collection all()
 */
class OwnedPermission extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'OwnedPermission';
    }
}
