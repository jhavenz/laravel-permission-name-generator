<?php


namespace Sourcefli\PermissionName\Tests\Feature\AllPermissions;

use Sourcefli\PermissionName\Facades\AllPermissions;
use Sourcefli\PermissionName\Tests\TestCase;

class TeamScopeTest extends TestCase
{

    /** @test */
    public function it_returns_correct_permission_for_browsing_owned_resources_using_set_scope_method_on_facade()
    {
        $expected = "{$this->resource}.[team].browse";
        $perm = AllPermissions::setScope("[team]")->{$this->resource}()->browse();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_browsing_owned_resources_using_for_owned_method_on_facade()
    {
        $expected = "{$this->resource}.[team].browse";
        $perm = AllPermissions::forTeam()->{$this->resource}()->browse();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_reading_owned_resources()
    {
        $expected = "{$this->resource}.[team].read";
        $perm = AllPermissions::forTeam()->{$this->resource}()->read();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_editing_owned_resources()
    {
        $expected = "{$this->resource}.[team].edit";
        $perm = AllPermissions::forTeam()->{$this->resource}()->edit();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_adding_owned_resources()
    {
        $expected = "{$this->resource}.[team].add";
        $perm = AllPermissions::forTeam()->{$this->resource}()->add();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_deleting_owned_resources()
    {
        $expected = "{$this->resource}.[team].delete";
        $perm = AllPermissions::forTeam()->{$this->resource}()->delete();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_restoring_owned_resources()
    {
        $expected = "{$this->resource}.[team].restore";
        $perm = AllPermissions::forTeam()->{$this->resource}()->restore();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_force_deleting_owned_resources()
    {
        $expected = "{$this->resource}.[team].force_delete";
        $perm = AllPermissions::forTeam()->{$this->resource}()->force_delete();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_wildcard_owned_resources()
    {
        $expected = "{$this->resource}.[team].*";
        $perm = AllPermissions::forTeam()->{$this->resource}()->wildcard();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

}