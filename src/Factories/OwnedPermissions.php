<?php

namespace Sourcefli\PermissionName\Factories;

use Illuminate\Support\Collection;
use Sourcefli\PermissionName\Contracts\BuildsPermissions;

class OwnedPermissions extends PermissionNameFactory implements BuildsPermissions
{
    protected Collection $permissions;

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
                    $permissionSet[] = "{$p}.{$accessLevel}";
                }
                return $permissionSet;
            });
    }
}
