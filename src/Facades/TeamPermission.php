<?php

namespace Sourcefli\PermissionName\Facades;

use Illuminate\Support\Facades\Facade;

class TeamPermission extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'TeamPermission';
    }
}
