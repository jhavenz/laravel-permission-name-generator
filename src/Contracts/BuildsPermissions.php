<?php


namespace Jhavenz\PermissionName\Contracts;


use Illuminate\Support\Collection;

interface BuildsPermissions
{
    public function collectPermissions(): Collection;
    public static function all(): Collection;
}
