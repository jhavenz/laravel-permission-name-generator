<?php

namespace Sourcefli\PermissionName\Tests\Feature;

use Sourcefli\PermissionName\Facades\OwnedPermission;
use Sourcefli\PermissionName\Tests\TestCase;

class OwnedPermissionTest extends TestCase
{

    /** @test */
    public function it_collects_all_configurations()
    {
        $expected = 'user.owned.browse';
        $perm = OwnedPermission::user()->browse();

        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }
}
