<?php


namespace Sourcefli\PermissionName\Tests\Feature\AllPermissions;

use Sourcefli\PermissionName\Facades\AllPermissions;
use Sourcefli\PermissionName\Tests\TestCase;

class OwnedScopeTest extends TestCase
{

    /** @test */
    public function it_returns_correct_permission_for_browsing_owned_resources_using_set_scope_method_on_facade()
    {
        $expected = "{$this->resource}.[owned].browse";
        $perm = AllPermissions::setScope('[owned]')->{$this->resource}()->browse();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_browsing_owned_resources()
    {
        $expected = "{$this->resource}.[owned].browse";
        $perm = AllPermissions::forOwned()->{$this->resource}()->browse();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_reading_owned_resources()
    {
        $expected = "{$this->resource}.[owned].read";
        $perm = AllPermissions::forOwned()->{$this->resource}()->read();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_editing_owned_resources()
    {
        $expected = "{$this->resource}.[owned].edit";
        $perm = AllPermissions::forOwned()->{$this->resource}()->edit();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_adding_owned_resources()
    {
        $expected = "{$this->resource}.[owned].add";
        $perm = AllPermissions::forOwned()->{$this->resource}()->add();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_deleting_owned_resources()
    {
        $expected = "{$this->resource}.[owned].delete";
        $perm = AllPermissions::forOwned()->{$this->resource}()->delete();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_restoring_owned_resources()
    {
        $expected = "{$this->resource}.[owned].restore";
        $perm = AllPermissions::forOwned()->{$this->resource}()->restore();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_force_deleting_owned_resources()
    {
        $expected = "{$this->resource}.[owned].force_delete";
        $perm = AllPermissions::forOwned()->{$this->resource}()->force_delete();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_wildcard_owned_resources()
    {
        $expected = "{$this->resource}.[owned].*";
        $perm = AllPermissions::forOwned()->{$this->resource}()->wildcard();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

}