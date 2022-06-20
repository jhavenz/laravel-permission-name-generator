<?php

namespace Jhavenz\PermissionName\Facades;

use Illuminate\Support\Facades\Facade;

class OwnedSettingPermission extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'OwnedSettingPermission';
    }
}
