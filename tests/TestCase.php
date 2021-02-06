<?php

namespace Sourcefli\GetPermissionName\Tests;

use Sourcefli\GetPermissionName\PermissionNameServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function getPackageProviders($app)
    {
        return [
            PermissionNameServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
