<?php


namespace Sourcefli\PermissionName\Factories;


use Illuminate\Support\Collection;

abstract class PermissionNameFactory
{
    protected Collection $permissions;

    protected const DEFAULT_ACCESS_LEVELS = [
        "browse",
        "read",
        "edit",
        "add",
        "delete",
        "restore",
        "force_delete",
        "*"
    ];

    public static function all (): Collection
    {
        return (new static)->permissions;
    }
}