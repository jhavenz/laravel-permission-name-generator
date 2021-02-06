<?php


namespace Sourcefli\PermissionName\Contracts;


use Illuminate\Support\Collection;

interface ResolvesPermissionString
{
    public function all(): Collection;
    public function browse(): string;
    public function read(): string;
    public function edit(): string;
    public function add(): string;
    public function delete(): string;
    public function forceDelete(): string;
    public function restore(): string;
    public function wildcard(): string;
}
