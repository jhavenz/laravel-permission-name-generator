<?php

namespace JhTech\GetPermissionName\Concerns;

use Illuminate\Support\Collection;

trait ManagesSettings
{


    public function collectSettings(array $permissionSettings = null)
    {
        $this->settings = collect($permissionSettings);
    }
}
