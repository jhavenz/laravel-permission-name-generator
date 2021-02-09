<?php

namespace Sourcefli\PermissionName\Factories;

use Illuminate\Support\Collection;
use Sourcefli\PermissionName\Contracts\BuildsPermissions;
use Sourcefli\PermissionName\Meta;
use Sourcefli\PermissionName\PermissionGenerator;

class OwnedPermissions extends PermissionNameFactory implements BuildsPermissions
{
    public function __construct()
    {
        $this->permissions = count(Meta::getResources())
            ? $this->collectPermissions()
            : collect();
    }

    public function collectPermissions(): Collection
    {
        return collect(Meta::getResources())
            ->map(function ($p) {
                $permissionSet = [];
                foreach (self::DEFAULT_ACCESS_LEVELS as $accessLevel) {
                    $permissionSet[] = "{$p}." . PermissionGenerator::SCOPE_OWNED . ".{$accessLevel}";
                }
                return $permissionSet;
            });
    }
}
