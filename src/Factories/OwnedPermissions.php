<?php

namespace Jhavenz\PermissionName\Factories;

use Illuminate\Support\Collection;
use Jhavenz\PermissionName\Contracts\BuildsPermissions;
use Jhavenz\PermissionName\Meta;
use Jhavenz\PermissionName\PermissionGenerator;

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
