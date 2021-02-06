<?php

namespace Sourcefli\PermissionName\Tests\Feature;

use Sourcefli\PermissionName\Facades\OwnedPermission;
use Sourcefli\PermissionName\Tests\TestCase;

class OwnedPermissionTest extends TestCase
{

    /** @test */
    public function it_collects_all_configurations()
    {
        dump(OwnedPermission::getFacadeRoot());
    }
}
