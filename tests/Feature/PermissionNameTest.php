<?php

namespace JhTech\GetPermissionName\Tests;

use JhTech\GetPermissionName\PermissionNameManager;


class PermissionNameTest extends TestCase
{

    /** @test */
    public function it_collects_all_configurations()
    {
        /** @var PermissionNameManager $mngr */
        $mngr = app('PermissionName');

        $this->assertNotNull($mngr->resources, "Failed asserting resources property was not null");
        $this->assertNotNull($mngr->ownershipTypes, "Failed asserting resources property was not null");
        $this->assertNotNull($mngr->settings, "Failed asserting resources property was not null");
    }
}
