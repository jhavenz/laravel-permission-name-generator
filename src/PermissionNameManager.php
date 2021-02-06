<?php

namespace Sourcefli\GetPermissionName;

use Illuminate\Support\Collection;
use Sourcefli\GetPermissionName\Concerns\ManagesSettings;
use Sourcefli\GetPermissionName\Concerns\ManagesResources;
use Sourcefli\GetPermissionName\Concerns\ManagesOwnershipTypes;

class PermissionNameManager
{
    use ManagesSettings,
        ManagesResources,
        ManagesOwnershipTypes;

    protected Collection $ownershipTypes;
    protected Collection $resources;
    protected ?Collection $settings;

    public function __construct()
    {
        $config = config('permission-name');

        $this->resources = collect($config['resources']);
        $this->ownershipTypes = collect($config['ownership_types']);
        $this->settings = $config['use_settings_types'] && count($config['settings'])
            ? collect($config['settings'])
            : null;
    }
}
