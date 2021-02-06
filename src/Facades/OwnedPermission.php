<?php

namespace Sourcefli\PermissionName\Facades;

use Illuminate\Support\Facades\Facade;

class OwnedPermission extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'OwnedPermission';
    }
}
