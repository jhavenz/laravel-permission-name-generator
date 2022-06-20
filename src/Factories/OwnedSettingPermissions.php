<?php

namespace Jhavenz\PermissionName\Factories;

use Illuminate\Support\Collection;
use Jhavenz\PermissionName\Contracts\BuildsPermissions;
use Jhavenz\PermissionName\Meta;
use Jhavenz\PermissionName\PermissionGenerator;

class OwnedSettingPermissions extends PermissionNameFactory implements BuildsPermissions
{
    public function __construct()
    {
        $this->permissions = count(Meta::getSettings())
            ? $this->collectPermissions()
            : collect();
    }

    public function collectPermissions (): Collection
    {
        return collect(Meta::getSettings())
            ->map(function ($p)  {
                $permissionSet = [];
                foreach (self::DEFAULT_ACCESS_LEVELS as $accessLevel) {
                    $permissionSet[] = "{$p}." .PermissionGenerator::SCOPE_OWNED_SETTING. ".{$accessLevel}";
                }
                return $permissionSet;
            });
    }
}
