<?php

namespace Sourcefli\PermissionName\Tests\Feature;

use Sourcefli\PermissionName\Adapters\AllPermissionsAdapter;
use Sourcefli\PermissionName\Exceptions\PermissionLookupException;
use Sourcefli\PermissionName\Facades\AllPermissions;
use Sourcefli\PermissionName\Tests\TestCase;

class AllPermissionTest extends TestCase
{

    /** @test */
    public function it_constructs_the_correct_amount_of_permission_names ()
    {
        $allPermissions = AllPermissions::all();

        $expectedCount = $this->accessLevelCount()
            * $this->ownershipTypeCount()
            * $this->resourceCount();

        $msg = "Total Permissions Produced {$allPermissions->count()}";
        fwrite(STDOUT, print_r($msg, TRUE));

        $this->assertCount($expectedCount, $allPermissions);
    }

    /** @test */
    public function it_requires_an_ownership_type_before_allowing_resources_to_be_called()
    {
        //Incorrect Usage
        $this->expectException(PermissionLookupException::class);
        AllPermissions::user()->browse();
    }

    /** @test */
    public function it_allows_owned_resource_method_to_be_called ()
    {
        $adapter = AllPermissionsAdapter::class;
        $scopeType = '[owned]';

        $this->assertInstanceOf($adapter, $manager = AllPermissions::forOwned());
        $this->assertTrue($manager->scopeType === $scopeType);
    }

    /** @test */
    public function it_allows_owned_setting_resource_method_to_be_called ()
    {
        $adapter = AllPermissionsAdapter::class;
        $scopeType = '[owned_setting]';

        $this->assertInstanceOf($adapter, $manager = AllPermissions::forOwnedSetting());
        $this->assertTrue($manager->scopeType === $scopeType);
    }

    /** @test */
    public function it_allows_team_resource_method_to_be_called ()
    {
        $adapter = AllPermissionsAdapter::class;
        $scopeType = '[team]';

        $this->assertInstanceOf($adapter, $manager = AllPermissions::forTeam());
        $this->assertTrue($manager->scopeType === $scopeType);
    }

    /** @test */
    public function it_allows_team_setting_resource_method_to_be_called ()
    {
        $adapter = AllPermissionsAdapter::class;
        $scopeType = '[team_setting]';

        $this->assertInstanceOf($adapter, $manager = AllPermissions::forTeamSetting());
        $this->assertTrue($manager->scopeType === $scopeType);
    }

    /** @test */
    public function it_returns_correct_permission_for_browsing_owned_resources()
    {
        $expected = 'user.[owned].browse';
        $perm = AllPermissions::setScope('[owned]')->user()->browse();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_reading_owned_resources()
    {
        $expected = 'user.[owned].read';
        $perm = AllPermissions::forOwned()->user()->read();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_editing_owned_resources()
    {
        $expected = 'user.owned.edit';
        $perm = AllPermissions::forOwned()->user()->edit();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_adding_owned_resources()
    {
        $expected = 'user.owned.add';
        $perm = AllPermissions::forOwned()->user()->add();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_deleting_owned_resources()
    {
        $expected = 'user.owned.delete';
        $perm = AllPermissions::forOwned()->user()->delete();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_restoring_owned_resources()
    {
        $expected = 'user.owned.restore';
        $perm = AllPermissions::forOwned()->user()->restore();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_force_deleting_owned_resources()
    {
        $expected = 'user.owned.force_delete';
        $perm = AllPermissions::forOwned()->user()->force_delete();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_wildcard_owned_resources()
    {
        $expected = 'user.[owned].*';
        $perm = AllPermissions::forOwned()->user()->wildcard();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_browsing_team_resources()
    {
        $expected = 'user.team.read';
        $perm = AllPermissions::forTeam()->user()->read();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_read()
    {
        $expected = 'user.team.read';
        $perm = AllPermissions::forTeam()->user()->read();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }

    /** @test */
    public function it_returns_correct_permission_for_edit()
    {
        $expected = '_setting.user.team.edit';
        $perm = AllPermissions::forTeamSetting()->user()->edit();
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }
}
