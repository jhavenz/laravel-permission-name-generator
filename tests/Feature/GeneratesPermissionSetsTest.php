<?php

namespace Sourcefli\PermissionName\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Sourcefli\PermissionName\Facades\AllPermissions;
use Sourcefli\PermissionName\Facades\OwnedPermission;
use Sourcefli\PermissionName\Facades\OwnedSettingPermission;
use Sourcefli\PermissionName\Facades\TeamPermission;
use Sourcefli\PermissionName\Facades\TeamSettingPermission;
use Sourcefli\PermissionName\Factories\PermissionNameFactory;
use Sourcefli\PermissionName\Meta;
use Sourcefli\PermissionName\PermissionGenerator;
use Sourcefli\PermissionName\Tests\TestCase;

class GeneratesPermissionSetsTest extends TestCase
{

    /** @test */
    public function it_builds_all_permissions_for_each_resource_using_all_permissions_facade()
    {
        $allPermissions = AllPermissions::all();
        $allAccessLevels = PermissionNameFactory::allAccessLevels();
        $allScopes = PermissionGenerator::allScopes();
        $allResources = array_merge(
            Meta::getResources(),
            Meta::getSettings()
        );

        $resourceCount = $this->resourceCount();
        $totalResourcePermissions = ($this->accessLevelCount() * ($resourceCount * $this->basicScopesCount()));

        $settingResourcesCount = $this->settingsResourcesCount();
        $totalSettingsResourcePermissions = ($this->accessLevelCount() * ($settingResourcesCount * $this->settingScopesCount()));

        $expectedCount = $totalResourcePermissions + $totalSettingsResourcePermissions;

        foreach ($allPermissions as $permission) {

            [$resource, $scope, $accessLevel] = explode('.', $permission);

            $this->assertContains($resource, $allResources, "Failed asserting resource of `{$resource}` is in config resources");
            $this->assertContains($scope, $allScopes, "Failed asserting `{$scope}` is in list of acceptable scopes");
            $this->assertContains($accessLevel, $allAccessLevels, "Failed asserting `{$accessLevel}` is in list of acceptable access levels");
        }

        $this->assertCount($expectedCount, $allPermissions);
    }

    /** @test */
    public function it_builds_owned_permissions_for_each_resource_listed_in_config_file()
    {
        $allResources = Meta::getResources();
        $allScopedPermissions = OwnedPermission::all();
        $scope = '[owned]';

        foreach ($allScopedPermissions as $permission) {

            $this->assertStringContainsString(
                $scope,
                $permission,
                "Failed asserting that each `OwnedPermission` set contains the string `owned`"
            );

            $resource = Str::before($permission, '.');

            $this->assertStringStartsWith($resource, $permission);

            $this->assertContains($resource, $allResources);
        }
    }

    /** @test */
    public function it_builds_team_permissions_for_each_resource_listed_in_config_file()
    {

        $allResources = Meta::getResources();
        $allScopedPermissions = TeamPermission::all();
        $scope = '[team]';

        foreach ($allScopedPermissions as $permission) {

            $this->assertStringContainsString(
                $scope,
                $permission,
                "Failed asserting that each `TeamPermission` set contains the string `owned`"
            );

            $resource = Str::before($permission, '.');

            $this->assertStringStartsWith($resource, $permission);

            $this->assertContains($resource, $allResources);
        }
    }

    /** @test */
    public function it_builds_owned_setting_permissions_for_each_setting_resource_listed_in_config_file()
    {
        $allSettingResources = Meta::getSettings();
        $allScopedPermissions = OwnedSettingPermission::all();
        $scope = '[owned_setting]';

        foreach ($allScopedPermissions as $permission) {

            $this->assertStringContainsString(
                $scope,
                $permission,
                "Failed asserting that each `OwnedSettingPermission` set contains the string `{$scope}`"
            );

            $resource = Str::before($permission, '.');

            $this->assertStringStartsWith($resource, $permission);

            $this->assertContains($resource, $allSettingResources);
        }
    }

    /** @test */
    public function it_builds_team_setting_permissions_for_each_setting_resource_listed_in_config_file()
    {
        $allSettingResources = Meta::getSettings();
        $allScopedPermissions = TeamSettingPermission::all();
        $scope = '[team_setting]';

        foreach ($allScopedPermissions as $permission) {

            $this->assertStringContainsString(
                $scope,
                $permission,
                "Failed asserting that each `TeamSettingPermission` set contains the string `{$scope}`"
            );

            $resource = Str::before($permission, '.');

            $this->assertStringStartsWith($resource, $permission);

            $this->assertContains($resource, $allSettingResources);
        }
    }


}
