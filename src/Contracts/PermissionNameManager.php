<?php


namespace Sourcefli\GetPermissionName\Contracts;


interface PermissionNameManager
{
    public function browse(): string;
    public function read(): string;
    public function edit(): string;
    public function add(): string;
    public function delete(): string;
    public function wildcard(): string;
}
