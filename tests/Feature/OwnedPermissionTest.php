<?php

namespace Jhavenz\PermissionName\Tests\Feature;

use Jhavenz\PermissionName\Facades\OwnedPermission;
use Jhavenz\PermissionName\Tests\TestCase;

class OwnedPermissionTest extends TestCase
{

    /** @test */
    public function it_returns_the_expected_permission_for_browse ()
    {
        $expectedPermission = "{$this->resource}.[owned].browse";

        $retrievedPermission = OwnedPermission::{$this->resource}()->browse();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_read ()
    {
        $expectedPermission = "{$this->resource}.[owned].read";

        $retrievedPermission = OwnedPermission::{$this->resource}()->read();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_edit ()
    {
        $expectedPermission = "{$this->resource}.[owned].edit";

        $retrievedPermission = OwnedPermission::{$this->resource}()->edit();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_add ()
    {
        $expectedPermission = "{$this->resource}.[owned].add";

        $retrievedPermission = OwnedPermission::{$this->resource}()->add();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_delete ()
    {
        $expectedPermission = "{$this->resource}.[owned].delete";

        $retrievedPermission = OwnedPermission::{$this->resource}()->delete();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_force_delete ()
    {
        $expectedPermission = "{$this->resource}.[owned].force_delete";

        $retrievedPermission = OwnedPermission::{$this->resource}()->force_delete();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_restore ()
    {
        $expectedPermission = "{$this->resource}.[owned].restore";

        $retrievedPermission = OwnedPermission::{$this->resource}()->restore();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_wildcard ()
    {
        $expectedPermission = "{$this->resource}.[owned].*";

        $retrievedPermission = OwnedPermission::{$this->resource}()->wildcard();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }
}
