<?php

namespace JhTech\GetPermissionName\Concerns;

use Illuminate\Support\Collection;

trait ManagesResources
{
    public function collectResources(array $permissionResources)
    {
        $this->resources = collect($permissionResources);
    }
}
