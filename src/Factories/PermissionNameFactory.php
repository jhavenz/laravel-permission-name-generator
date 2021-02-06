<?php


namespace Sourcefli\PermissionName\Factories;


abstract class PermissionNameFactory
{
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
}