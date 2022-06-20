<?php

namespace Jhavenz\PermissionName\Tests\Feature;

use Jhavenz\PermissionName\Facades\OwnedSettingPermission;
use Jhavenz\PermissionName\Tests\TestCase;

class OwnedSettingPermissionTest extends TestCase
{

    /** @test */
    public function it_returns_the_expected_permission_for_browse ()
    {
        $expectedPermission = "{$this->settingsResource}.[owned_setting].browse";

        $retrievedPermission = OwnedSettingPermission::{$this->settingsResource}()->browse();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_read ()
    {
        $expectedPermission = "{$this->settingsResource}.[owned_setting].read";

        $retrievedPermission = OwnedSettingPermission::{$this->settingsResource}()->read();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_edit ()
    {
        $expectedPermission = "{$this->settingsResource}.[owned_setting].edit";

        $retrievedPermission = OwnedSettingPermission::{$this->settingsResource}()->edit();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_add ()
    {
        $expectedPermission = "{$this->settingsResource}.[owned_setting].add";

        $retrievedPermission = OwnedSettingPermission::{$this->settingsResource}()->add();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_delete ()
    {
        $expectedPermission = "{$this->settingsResource}.[owned_setting].delete";

        $retrievedPermission = OwnedSettingPermission::{$this->settingsResource}()->delete();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_force_delete ()
    {
        $expectedPermission = "{$this->settingsResource}.[owned_setting].force_delete";

        $retrievedPermission = OwnedSettingPermission::{$this->settingsResource}()->force_delete();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_restore ()
    {
        $expectedPermission = "{$this->settingsResource}.[owned_setting].restore";

        $retrievedPermission = OwnedSettingPermission::{$this->settingsResource}()->restore();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_wildcard ()
    {
        $expectedPermission = "{$this->settingsResource}.[owned_setting].*";

        $retrievedPermission = OwnedSettingPermission::{$this->settingsResource}()->wildcard();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }
}
