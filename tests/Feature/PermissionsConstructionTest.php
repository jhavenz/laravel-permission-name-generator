<?php

namespace Sourcefli\PermissionName\Tests\Feature;

use Illuminate\Support\Str;
use Sourcefli\PermissionName\Facades\OwnedPermission;
use Sourcefli\PermissionName\Facades\TeamPermission;
use Sourcefli\PermissionName\Tests\TestCase;

class PermissionsConstructionTest extends TestCase
{



    /** @test */
    public function it_builds_owned_permissions_for_each_resource_using_facade()
    {
        $allOwnedPermissions = OwnedPermission::all();

        $expectedCount = $this->totalPermissionsForOneOwnershipType('owned');

        foreach ($allOwnedPermissions as $permission) {
            $this->assertStringContainsString(
                '.owned.',
                $permission,
                "Failed asserting that each `OwnedPermission` set contains the string `owned`"
            );

            //Each resource listed in config..
            $resource = $this->extractResourceNameFromPermission($permission);


            if (Str::startsWith($permission, '_setting.')) {
                $permission = Str::after($permission, '_setting.');
            }

            $this->assertContains($resource, $this->allUserResources());
            $this->assertStringStartsWith($resource, $permission);
        }

        $this->assertCount($expectedCount, $allOwnedPermissions);
    }

    /** @test */
    public function it_builds_team_permissions_for_each_resource_listed_in_config_file()
    {
        $allResources = config('permission-name.resources');
        $allTeamPermissions = TeamPermission::all()->flatten();
        $ownershipType = 'owned';

        foreach ($allOwnedPermissions as $permission) {

            $this->assertStringContainsString(
                $ownershipType,
                $permission,
                "Failed asserting that each `OwnedPermission` set contains the string `owned`"
            );

            $resource = Str::before($permission, '.');

            $this->assertStringStartsWith($resource, $permission);
            $this->assertContains($resource, $allResources);
        }
    }


}
