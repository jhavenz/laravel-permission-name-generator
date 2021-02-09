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

    protected const RESOURCE_REQUIRED_ACCESS_LEVELS = [
        "browse",
        "read",
        "edit",
        "add",
        "delete",
        "restore",
        "force_delete",
        "wildcard"
    ];

    public static function all (): Collection
    {
        return (new static)->permissions->flatten();
    }

    public static function allAccessLevels ()
    {
        return self::DEFAULT_ACCESS_LEVELS;
    }

    public static function noAccessWithoutResource ()
    {
        return self::RESOURCE_REQUIRED_ACCESS_LEVELS;
    }
}