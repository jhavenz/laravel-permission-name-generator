<?php


namespace Sourcefli\PermissionName\Tests\Feature\AllPermissions;

use Illuminate\Support\Facades\Config;
use Sourcefli\PermissionName\Facades\AllPermissions;
use Sourcefli\PermissionName\Tests\TestCase;

class OwnedSettingScopeTest extends TestCase
{

    /** @test */
    public function it_returns_correct_permission_for_browsing_owned_resources_using_set_scope_method_on_facade()
    {
        $expected = "{$this->settingsResource}.[owned_setting].browse";
        $perm = AllPermissions::setScope('[owned_setting]')->{$this->settingsResource}()->browse();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_browsing_owned_resources()
    {
        $expected = "{$this->settingsResource}.[owned_setting].browse";
        $perm = AllPermissions::forOwnedSetting()->{$this->settingsResource}()->browse();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_reading_owned_resources()
    {
        $expected = "{$this->settingsResource}.[owned_setting].read";
        $perm = AllPermissions::forOwnedSetting()->{$this->settingsResource}()->read();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_editing_owned_resources()
    {
        $expected = "{$this->settingsResource}.[owned_setting].edit";
        $perm = AllPermissions::forOwnedSetting()->{$this->settingsResource}()->edit();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_adding_owned_resources()
    {
        $expected = "{$this->settingsResource}.[owned_setting].add";
        $perm = AllPermissions::forOwnedSetting()->{$this->settingsResource}()->add();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_deleting_owned_resources()
    {
        $expected = "{$this->settingsResource}.[owned_setting].delete";
        $perm = AllPermissions::forOwnedSetting()->{$this->settingsResource}()->delete();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_restoring_owned_resources()
    {
        $expected = "{$this->settingsResource}.[owned_setting].restore";
        $perm = AllPermissions::forOwnedSetting()->{$this->settingsResource}()->restore();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_force_deleting_owned_resources()
    {
        $expected = "{$this->settingsResource}.[owned_setting].force_delete";
        $perm = AllPermissions::forOwnedSetting()->{$this->settingsResource}()->force_delete();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_wildcard_owned_resources()
    {
        $expected = "{$this->settingsResource}.[owned_setting].*";
        $perm = AllPermissions::forOwnedSetting()->{$this->settingsResource}()->wildcard();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

}