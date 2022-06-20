<?php

namespace Jhavenz\PermissionName\Tests\Feature;

use Illuminate\Support\Collection;
use Jhavenz\PermissionName\Adapters\OwnedPermissionsAdapter;
use Jhavenz\PermissionName\Adapters\OwnedSettingPermissionsAdapter;
use Jhavenz\PermissionName\Adapters\TeamPermissionsAdapter;
use Jhavenz\PermissionName\Adapters\TeamSettingPermissionsAdapter;
use Jhavenz\PermissionName\Tests\TestCase;

class GlobalHelpersTest extends TestCase
{

    /** =========== Team ============== */

    /** @test */
    public function it_returns_a_team_permission_adapter_when_a_parameter_is_used ()
    {
        $expected = TeamPermissionsAdapter::class;
        $tp = teamPermission('billing');

        $this->assertInstanceOf($expected, $tp);
    }

    /** @test */
    public function it_returns_all_team_permissions_when_no_parameter_is_passed_in ()
    {
        $expected = Collection::class;
        $allTeamPermissions = teamPermission();

        $this->assertInstanceOf($expected, $allTeamPermissions);

        //8 access levels for each 'resource' * total resources
        $this->assertCount($this->resourceCount() * $this->accessLevelCount(), $allTeamPermissions);
    }

    /** @test */
    public function it_returns_correct_team_permission_when_parameter_is_passed_in ()
    {
        $expected = 'billing.[team].browse';
        $tp = teamPermission('billing')->browse();

        $this->assertSame($expected, $tp);
    }

    /** @test */
    public function it_returns_a_team_settings_permission_adapter_when_a_parameter_is_used ()
    {
        $expected = TeamSettingPermissionsAdapter::class;
        $tp = teamSettingPermission('phone_numbers');

        $this->assertInstanceOf($expected, $tp);
    }

    /** @test */
    public function it_returns_all_team_settings_permissions_when_no_parameter_is_passed_in ()
    {
        $expected = Collection::class;
        $allTeamSettingPermissions = teamSettingPermission();

        $this->assertInstanceOf($expected, $allTeamSettingPermissions);

        //8 access levels for each 'setting' * total settings
        $this->assertCount($this->settingsResourcesCount() * $this->accessLevelCount(), $allTeamSettingPermissions);
    }

    /** @test */
    public function it_returns_correct_team_settings_permission_when_parameter_is_passed_in ()
    {
        $expected = 'phone_numbers.[team_setting].browse';
        $tp = teamSettingPermission('phone_numbers')->browse();

        $this->assertSame($expected, $tp);
    }

    /** =========== Owned ============== */

    /** @test */
    public function it_returns_an_owned_permission_adapter_when_a_parameter_is_used ()
    {
        $expected = OwnedPermissionsAdapter::class;
        $tp = ownedPermission('billing');

        $this->assertInstanceOf($expected, $tp);
    }

    /** @test */
    public function it_returns_all_owned_permissions_when_no_parameter_is_passed_in ()
    {
        $expected = Collection::class;
        $allOwnedPermissions = ownedPermission();

        $this->assertInstanceOf($expected, $allOwnedPermissions);

        //8 access levels for each 'resource' * total resources
        $this->assertCount($this->resourceCount() * $this->accessLevelCount(), $allOwnedPermissions);
    }

    /** @test */
    public function it_returns_correct_owned_permission_when_parameter_is_passed_in ()
    {
        $expected = 'billing.[owned].browse';
        $tp = ownedPermission('billing')->browse();

        $this->assertSame($expected, $tp);
    }

    /** @test */
    public function it_returns_a_owned_settings_permission_adapter_when_a_parameter_is_used ()
    {
        $expected = OwnedSettingPermissionsAdapter::class;
        $tp = ownedSettingPermission('phone_numbers');

        $this->assertInstanceOf($expected, $tp);
    }

    /** @test */
    public function it_returns_all_owned_settings_permissions_when_no_parameter_is_passed_in ()
    {
        $expected = Collection::class;
        $allOwnedSettingPermissions = ownedSettingPermission();

        $this->assertInstanceOf($expected, $allOwnedSettingPermissions);

        //8 access levels for each 'setting' * total settings
        $this->assertCount($this->settingsResourcesCount() * $this->accessLevelCount(), $allOwnedSettingPermissions);
    }

    /** @test */
    public function it_returns_correct_owned_settings_permission_when_parameter_is_passed_in ()
    {
        $expected = 'phone_numbers.[owned_setting].browse';
        $tp = ownedSettingPermission('phone_numbers')->browse();

        $this->assertSame($expected, $tp);
    }

}
