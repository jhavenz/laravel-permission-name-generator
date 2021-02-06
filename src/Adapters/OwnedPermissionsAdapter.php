<?php


namespace Sourcefli\PermissionName\Adapters;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Sourcefli\PermissionName\Contracts\ResolvesPermissionString;
use Sourcefli\PermissionName\Factories\OwnedPermissions;
use Sourcefli\PermissionName\PermissionName;

class OwnedPermissionsAdapter implements ResolvesPermissionString
{
    protected \Illuminate\Support\Collection $permissions;
    protected PermissionName $permissionManager;

    public function __construct()
    {
        $this->permissions = (new OwnedPermissions)->collectPermissions();
        $this->permissionManager = new PermissionName;
    }

    public function __call ($name, $arguments): OwnedPermissionsAdapter
    {
        if ($this->permissionManager->isValidResource($name)) {
            $this->permissionManager->setCategory($name);
        }

        $this->permissionManager->setOwnershipType('owned');

        return $this;
    }

    public function browse(): string
    {
        $this->permissionManager->dynamicReduce();

        return $this
            ->permissionManager
            ->abilities
            ->first(fn ($p) => Str::endsWith($p, '.browse'));
    }

    public function read(): string
    {
        $this->permissionManager->dynamicReduce();

        return $this
            ->permissionManager
            ->abilities
            ->first(fn ($p) => Str::endsWith($p, '.read'));
    }

    public function edit(): string
    {
        $this->permissionManager->dynamicReduce();

        return $this
            ->permissionManager
            ->abilities
            ->first(fn ($p) => Str::endsWith($p, '.edit'));
    }

    public function add(): string
    {
        $this->permissionManager->dynamicReduce();

        return $this
            ->permissionManager
            ->abilities
            ->first(fn ($p) => Str::endsWith($p, '.add'));
    }

    public function delete(): string
    {
        $this->permissionManager->dynamicReduce();

        return $this
            ->permissionManager
            ->abilities
            ->first(fn ($p) => Str::endsWith($p, '.delete'));
    }

    public function forceDelete (): string
    {
        $this->permissionManager->dynamicReduce();

        return $this
            ->permissionManager
            ->abilities
            ->first(fn ($p) => Str::endsWith($p, '.force_delete'));
    }

    public function restore (): string
    {
        $this->permissionManager->dynamicReduce();

        return $this
            ->permissionManager
            ->abilities
            ->first(fn ($p) => Str::endsWith($p, '.restore'));
    }

    public function wildcard(): string
    {
        $this->permissionManager->dynamicReduce();

        return $this
            ->permissionManager
            ->abilities
            ->first(fn ($p) => Str::contains($p, '.*'));
    }

    public function all (): Collection
    {
        return $this->permissions;
    }
}