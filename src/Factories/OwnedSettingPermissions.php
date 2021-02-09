<?php

namespace Sourcefli\PermissionName\Factories;

use Illuminate\Support\Collection;
use Sourcefli\PermissionName\Contracts\BuildsPermissions;
use Sourcefli\PermissionName\PermissionGenerator;

class OwnedSettingPermissions extends PermissionNameFactory implements BuildsPermissions
{
    public function __construct()
    {
        $this->permissions = $this->collectPermissions();
    }

    public function collectPermissions (): Collection
    {
        return collect(config('permission-name.resources'))
            ->map(function ($p)  {
                $permissionSet = [];
                foreach (self::DEFAULT_ACCESS_LEVELS as $accessLevel) {
                    $permissionSet[] = "_setting.{$p}." .PermissionGenerator::SCOPE_OWNED_SETTING. ".{$accessLevel}";
                }
                return $permissionSet;
            });
    }
}
