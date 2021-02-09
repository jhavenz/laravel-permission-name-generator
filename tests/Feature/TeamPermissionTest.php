<?php

namespace Sourcefli\PermissionName\Tests\Feature;

use Sourcefli\PermissionName\Facades\TeamPermission;
use Sourcefli\PermissionName\Tests\TestCase;

class TeamPermissionTest extends TestCase
{

    /** @test */
    public function it_returns_the_expected_permission_for_browse ()
    {
        $expectedPermission = "{$this->resource}.[team].browse";

        $retrievedPermission = TeamPermission::{$this->resource}()->browse();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_read ()
    {
        $expectedPermission = "{$this->resource}.[team].read";

        $retrievedPermission = TeamPermission::{$this->resource}()->read();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_edit ()
    {
        $expectedPermission = "{$this->resource}.[team].edit";

        $retrievedPermission = TeamPermission::{$this->resource}()->edit();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_add ()
    {
        $expectedPermission = "{$this->resource}.[team].add";

        $retrievedPermission = TeamPermission::{$this->resource}()->add();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_delete ()
    {
        $expectedPermission = "{$this->resource}.[team].delete";

        $retrievedPermission = TeamPermission::{$this->resource}()->delete();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_force_delete ()
    {
        $expectedPermission = "{$this->resource}.[team].force_delete";

        $retrievedPermission = TeamPermission::{$this->resource}()->force_delete();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_restore ()
    {
        $expectedPermission = "{$this->resource}.[team].restore";

        $retrievedPermission = TeamPermission::{$this->resource}()->restore();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_wildcard ()
    {
        $expectedPermission = "{$this->resource}.[team].*";

        $retrievedPermission = TeamPermission::{$this->resource}()->wildcard();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }
}
