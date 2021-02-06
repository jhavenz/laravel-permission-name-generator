<?php

namespace Sourcefli\PermissionName\Facades;

use Illuminate\Support\Facades\Facade;

class TeamSettingPermission extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'TeamSettingPermission';
    }
}
