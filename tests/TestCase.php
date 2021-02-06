<?php

namespace Sourcefli\PermissionName\Tests;

use Sourcefli\PermissionName\PermissionNameServiceProvider;

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
