<?php


namespace Sourcefli\PermissionName\Tests\Feature\AllPermissions;

use Sourcefli\PermissionName\Facades\AllPermissions;
use Sourcefli\PermissionName\Tests\TestCase;

class TeamSettingScopeTest extends TestCase
{

    /** @test */
    public function it_returns_correct_permission_for_browsing_owned_resources_using_set_scope_method_on_facade()
    {
        $expected = "{$this->settingsResource}.[team_setting].browse";
        $perm = AllPermissions::setScope("[team_setting]")->{$this->settingsResource}()->browse();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_browsing_owned_resources()
    {
        $expected = "{$this->settingsResource}.[team_setting].browse";
        $perm = AllPermissions::forTeamSetting()->{$this->settingsResource}()->browse();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_reading_owned_resources()
    {
        $expected = "{$this->settingsResource}.[team_setting].read";
        $perm = AllPermissions::forTeamSetting()->{$this->settingsResource}()->read();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_editing_owned_resources()
    {
        $expected = "{$this->settingsResource}.[team_setting].edit";
        $perm = AllPermissions::forTeamSetting()->{$this->settingsResource}()->edit();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_adding_owned_resources()
    {
        $expected = "{$this->settingsResource}.[team_setting].add";
        $perm = AllPermissions::forTeamSetting()->{$this->settingsResource}()->add();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_deleting_owned_resources()
    {
        $expected = "{$this->settingsResource}.[team_setting].delete";
        $perm = AllPermissions::forTeamSetting()->{$this->settingsResource}()->delete();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_restoring_owned_resources()
    {
        $expected = "{$this->settingsResource}.[team_setting].restore";
        $perm = AllPermissions::forTeamSetting()->{$this->settingsResource}()->restore();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_force_deleting_owned_resources()
    {
        $expected = "{$this->settingsResource}.[team_setting].force_delete";
        $perm = AllPermissions::forTeamSetting()->{$this->settingsResource}()->force_delete();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_wildcard_owned_resources()
    {
        $expected = "{$this->settingsResource}.[team_setting].*";
        $perm = AllPermissions::forTeamSetting()->{$this->settingsResource}()->wildcard();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

}