<?php

namespace Sourcefli\PermissionName\Tests\Feature;

use Sourcefli\PermissionName\Adapters\AllPermissionsAdapter;
use Sourcefli\PermissionName\Exceptions\PermissionLookupException;
use Sourcefli\PermissionName\Facades\AllPermissions;
use Sourcefli\PermissionName\Tests\TestCase;

class AllPermissionsFacadeTest extends TestCase
{

    /** @test */
    public function it_constructs_the_correct_amount_of_permission_names ()
    {
        $allPermissions = AllPermissions::all();

        $resourceCount = $this->resourceCount();
        $totalResourcePermissions = ($this->accessLevelCount() * ($resourceCount * $this->basicScopesCount()));

        $settingResourcesCount = $this->settingsResourcesCount();
        $totalSettingsResourcePermissions = ($this->accessLevelCount() * ($settingResourcesCount * $this->settingScopesCount()));

        $expectedCount = $totalResourcePermissions + $totalSettingsResourcePermissions;

        $msg = "Produced {$allPermissions->count()} Total Permission Names. {$totalResourcePermissions} Permissions for {$resourceCount} Resources in the config file, and {$totalSettingsResourcePermissions} Permissions for {$settingResourcesCount} `Settings` Resources listed in the config file";

        fwrite(STDOUT, print_r($msg, TRUE));

        $this->assertCount($expectedCount, $allPermissions);
    }

    /** @test */
    public function it_requires_a_scope_before_allowing_resources_to_be_called()
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
}
