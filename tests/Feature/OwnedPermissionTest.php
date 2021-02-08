<?php

namespace Sourcefli\PermissionName\Tests\Feature;

use Sourcefli\PermissionName\Facades\TeamPermission;
use Sourcefli\PermissionName\Tests\TestCase;

class OwnedPermissionTest extends TestCase
{

    /** @test */
    public function it_returns_the_expected_permission_for_browse ()
    {
        $expectedPermission = 'user.team.browse';

        $retrievedPermission = TeamPermission::user()->browse();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_read ()
    {
        $expectedPermission = 'user.team.read';

        $retrievedPermission = TeamPermission::user()->read();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_edit ()
    {
        $expectedPermission = 'user.team.edit';

        $retrievedPermission = TeamPermission::user()->edit();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_add ()
    {
        $expectedPermission = 'user.team.add';

        $retrievedPermission = TeamPermission::user()->add();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_delete ()
    {
        $expectedPermission = 'user.team.delete';

        $retrievedPermission = TeamPermission::user()->delete();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_force_delete ()
    {
        $expectedPermission = 'user.team.force_delete';

        $retrievedPermission = TeamPermission::user()->force_delete();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_restore ()
    {
        $expectedPermission = 'user.team.restore';

        $retrievedPermission = TeamPermission::user()->restore();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_wildcard ()
    {
        $expectedPermission = 'user.team.*';

        $retrievedPermission = TeamPermission::user()->wildcard();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }
}
