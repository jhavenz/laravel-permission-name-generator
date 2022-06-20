<?php

namespace Jhavenz\PermissionName\Tests\Feature;

use Jhavenz\PermissionName\Facades\TeamSettingPermission;
use Jhavenz\PermissionName\Tests\TestCase;

class TeamSettingPermissionTest extends TestCase
{

    /** @test */
    public function it_returns_the_expected_permission_for_browse ()
    {
        $expectedPermission = "{$this->settingsResource}.[team_setting].browse";

        $retrievedPermission = TeamSettingPermission::{$this->settingsResource}()->browse();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_read ()
    {
        $expectedPermission = "{$this->settingsResource}.[team_setting].read";

        $retrievedPermission = TeamSettingPermission::{$this->settingsResource}()->read();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_edit ()
    {
        $expectedPermission = "{$this->settingsResource}.[team_setting].edit";

        $retrievedPermission = TeamSettingPermission::{$this->settingsResource}()->edit();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_add ()
    {
        $expectedPermission = "{$this->settingsResource}.[team_setting].add";

        $retrievedPermission = TeamSettingPermission::{$this->settingsResource}()->add();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_delete ()
    {
        $expectedPermission = "{$this->settingsResource}.[team_setting].delete";

        $retrievedPermission = TeamSettingPermission::{$this->settingsResource}()->delete();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_force_delete ()
    {
        $expectedPermission = "{$this->settingsResource}.[team_setting].force_delete";

        $retrievedPermission = TeamSettingPermission::{$this->settingsResource}()->force_delete();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_restore ()
    {
        $expectedPermission = "{$this->settingsResource}.[team_setting].restore";

        $retrievedPermission = TeamSettingPermission::{$this->settingsResource}()->restore();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }

    /** @test */
    public function it_returns_the_expected_permission_for_wildcard ()
    {
        $expectedPermission = "{$this->settingsResource}.[team_setting].*";

        $retrievedPermission = TeamSettingPermission::{$this->settingsResource}()->wildcard();

        $this->assertSame($expectedPermission, $retrievedPermission);
    }
}
