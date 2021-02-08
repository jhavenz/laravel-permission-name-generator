<?php


namespace Sourcefli\PermissionName;


use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Sourcefli\PermissionName\Adapters\AllPermissionsAdapter;
use Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter;
use Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter;
use Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter;
use Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter;
use Sourcefli\PermissionName\Exceptions\PermissionLookupException;

abstract class PermissionManager
{

    public Collection $abilities;
    protected string $resource;
    protected PermissionGenerator $generator;
    protected ?string $ownershipType;
    protected Collection $permissions;
    protected array $resources = [];
    protected array $settings = [];

    //abstract public function ownershipType(): string;

    protected const OWNERSHIP_TYPES = [
        "all", "owned", "team", "owned_setting", "team_setting"
    ];

    public function __construct()
    {
        $this->ownershipType = $this->runtimeOwnershipType();
        $this->validOwnershipType();
        $this->resources = config('permission-name.resources');
        $this->settings = config('permission-name.settings');
        $this->abilities = collect();
        $this->generator = new PermissionGenerator;
        $this->permissions = $this->filterAllRelatedPermissions();
    }

    private function validOwnershipType ()
    {
        if (! $this->ownershipType || ! in_array($this->ownershipType, self::OWNERSHIP_TYPES, true)) {
            throw new PermissionLookupException(
                "Unable to determine ownership type. Please instantiate using one of the facades/adapters so it can determined automatically."
            );
        }
    }

    public function browse(): string
    {
        $this->resetAndReduceByResource();

        return $this
            ->abilities
            ->first(fn ($p) => Str::endsWith($p, '.browse'));
    }

    public function read(): string
    {
        $this->resetAndReduceByResource();

        return $this
            ->abilities
            ->first(fn ($p) => Str::endsWith($p, '.read'));
    }

    public function edit(): string
    {
        $this->resetAndReduceByResource();

        return $this
            ->abilities
            ->first(fn ($p) => Str::endsWith($p, '.edit'));
    }

    public function add(): string
    {
        $this->resetAndReduceByResource();

        return $this
            ->abilities
            ->first(fn ($p) => Str::endsWith($p, '.add'));
    }

    public function delete(): string
    {
        $this->resetAndReduceByResource();

        return $this
            ->abilities
            ->first(fn ($p) => Str::endsWith($p, '.delete'));
    }

    public function force_delete (): string
    {
        $this->resetAndReduceByResource();

        return $this
            ->abilities
            ->first(fn ($p) => Str::endsWith($p, '.force_delete'));
    }

    public function restore (): string
    {
        $this->resetAndReduceByResource();

        return $this
            ->abilities
            ->first(fn ($p) => Str::endsWith($p, '.restore'));
    }

    public function wildcard(): string
    {
        $this->resetAndReduceByResource();

        return $this
            ->abilities
            ->first(fn ($p) => Str::contains($p, '.*'));
    }

    public function all (): Collection
    {
        return $this->permissions;
    }

    protected function getAll (): Collection
    {
        return $this->generator->allPermissions();
    }

    public function setResource(string $resource): PermissionManager
    {
        if (Str::startsWith($resource, '_setting.')) {
            $this->isValidSettingItem($resource);
            $this->resource = collect($this->settings)->first(fn ($s) => $s === $resource);
        } else {
            $this->isValidResource($resource);
            $this->resource = collect($this->resources)->first(fn ($s) => $s === $resource);
        }

        return $this;
    }

    public function resetAndReduceByResource ()
    {
        $this->validResourceIsSet();
        $this->reset();
        $this->filterForResource();
    }

    public function validResourceIsSet()
    {
        if (!isset($this->resource)) {
            throw new PermissionLookupException("A Resource must be set before retrieving a specific permission");
        }
    }

    public function filterForResource()
    {
        $this->abilities = $this
            ->permissions
            ->filter(
                fn ($p) =>
                Str::startsWith($p, $this->resource) &&
                Str::contains($p, '.'.$this->ownershipType.'.')
            );

        return $this;
    }

    public function reset()
    {
        $this->abilities = collect();

        return $this;
    }


    protected function filterAllRelatedPermissions()
    {
        if ($this->ownershipType === 'all') return $this->getAll();

        if ($this->ownershipType === 'team') {
            return $this
                ->getAll()
                ->filter(
                    fn ($p) =>
                        !Str::startsWith($p, 'team') &&
                        !Str::contains($p, '_setting') &&
                        Str::contains($p, '.team.')
                );
        }

        if ($this->ownershipType === 'owned') {
            return $this
                ->getAll()
                ->filter(
                    fn ($p) =>
                        !Str::startsWith($p, 'owned') &&
                        !Str::contains($p, '_setting') &&
                        Str::contains($p, '.owned.')
                );
        }

        if ($this->ownershipType === 'owned_setting') {
            return $this
                ->getAll()
                ->filter(
                    fn ($p) =>
                        Str::startsWith($p, '_setting') &&
                        Str::contains($p, '.owned.')
                );
        }

        if ($this->ownershipType === 'team_setting') {
            return $this
                ->getAll()
                ->filter(
                    fn ($p) =>
                        Str::startsWith($p, '_setting') &&
                        Str::contains($p, '.team.')
                );
        }

        throw new PermissionLookupException(
            "Unable to determine ownership type. Please instantiate using one of the facades/adapters so it can determined automatically."
        );
    }

    private function isValidSettingItem(string $settingItem)
    {
        if (!count($this->settings)) {
            throw new PermissionLookupException(
                "No setting-related permissions were specified within the `permission-name.settings` configuration"
            );
        }

        $settingItem = Str::afterLast($settingItem, '.');

        if (!in_array($settingItem, $this->settings, true)) {
            throw new PermissionLookupException(
                "Settings permission of {$settingItem} is not a valid settings item. All settings-related permissions should be listed in the `permission-name.settings` configuration."
            );
        }
    }

    public function isValidResource(string $resource)
    {
        if (!count($this->resources)) {
            throw new PermissionLookupException(
                "No resources were specified within the `permission-name.resources` configuration"
            );
        }

        if (!in_array($resource, $this->resources, true)) {
            throw new PermissionLookupException(
                "Resource of {$resource} is not valid. Only `resources` listed in the `config.permission-name.resources` can be used as facade methods, or check out the `Sourcefli\PermissionName\Contracts\RetrievesPermissions` contract to see which retrieval methods can be chained. i.e. `OwnedPermission::user()->browse()`. `user` is the resource and `browse` is the retrieval method. This example would return the `user.owned.browse` permission"
            );
        }

        return true;
    }

    private function runtimeOwnershipType ()
    {

        return $this instanceof OwnedPermissionsAdapter
            ? 'owned'
            : ($this instanceof TeamPermissionsAdapter
                ? 'team'
                : ($this instanceof OwnedSettingPermissionsAdapter
                    ? 'owned_setting'
                    : ($this instanceof TeamSettingPermissionsAdapter
                        ? 'team_setting'
                        : ($this instanceof AllPermissionsAdapter
                            ? 'all'
                            : null
                        )  )   )   );
    }

    public function __call ($name, $arguments): PermissionManager
    {
        if ($this->isValidResource($name)) {
            $this->setResource($name);
        }

        return $this;
    }

}