<?php


namespace Sourcefli\PermissionName\Adapters;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Sourcefli\PermissionName\Contracts\ResolvesPermissionString;
use Sourcefli\PermissionName\Factories\TeamPermissions;
use Sourcefli\PermissionName\PermissionName;

class TeamPermissionsAdapter implements ResolvesPermissionString
{
    protected \Illuminate\Support\Collection $permissions;
    protected PermissionName $permissionManager;

    public function __construct()
    {
        $this->permissions = (new TeamPermissions)->collectPermissions();
        $this->permissionManager = new PermissionName;
    }

    public function __call ($name, $arguments): TeamPermissionsAdapter
    {
        if ($this->permissionManager->isValidResource($name)) {
            $this->permissionManager->setCategory($name);
        }

        $this->permissionManager->setOwnershipType('owned');

        return $this;
    }

    public function browse(): string
    {
        $this->validCategoryIsSet();
        $this->reset();
        $this->filterForCategory();
        return $this->abilities->first(fn ($p) => Str::contains($p, 'browse'));
    }

    public function read(): string
    {
        $this->validCategoryIsSet();
        $this->reset();
        $this->filterForCategory();
        return $this->abilities->first(fn ($p) => Str::contains($p, 'read'));
    }

    public function edit(): string
    {
        $this->validCategoryIsSet();
        $this->reset();
        $this->filterForCategory();
        return $this->abilities->first(fn ($p) => Str::contains($p, 'edit'));
    }

    public function add(): string
    {
        $this->permissionManager->validCategoryIsSet();
        $this->permissionManager->reset();
        $this->permissionManager->filterForCategory();
        return $this->abilities->first(fn ($p) => Str::contains($p, 'add'));
    }

    public function delete(): string
    {
        $this->validCategoryIsSet();
        $this->reset();
        $this->filterForCategory();
        return $this->abilities->first(fn ($p) => Str::contains($p, 'delete'));
    }

    public function wildcard()
    {
        $this->validCategoryIsSet();
        $this->reset();
        $this->filterForCategory();
        return $this->abilities->first(fn ($p) => Str::endsWith($p, '.*'));
    }

    public function forceDelete (): string
    {
        // TODO: Implement forceDelete() method.
    }

    public function restore (): string
    {
        // TODO: Implement restore() method.
    }

    public function all (): Collection
    {
        return $this->permissions;
    }
}