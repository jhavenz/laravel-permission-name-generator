<?php

namespace JhTech\GetPermissionName\Concerns;

use Illuminate\Support\Collection;

trait ManagesOwnershipTypes
{

    public function collectOwnershipTypes(array $permissionOwnershipTypes)
    {
        $this->ownershipTypes = collect($permissionOwnershipTypes);
    }
}
