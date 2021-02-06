<?php

namespace Sourcefli\PermissionName\Tests\Feature;

use Illuminate\Support\Str;
use Sourcefli\PermissionName\Facades\OwnedPermission;
use Sourcefli\PermissionName\Factories\OwnedPermissions;
use Sourcefli\PermissionName\Tests\TestCase;

class PermissionsConstructionTest extends TestCase
{

    /** @test */
    public function it_builds_owned_permissions_for_each_resource_config_file()
    {
        $allResources = config('permission-name.resources');
        $allOwnedPermissions = OwnedPermissions::all()->flatten();
        $ownershipType = 'owned';

        foreach ($allOwnedPermissions as $permission) {

            $this->assertStringContainsString(
                $ownershipType,
                $permission,
                "Failed asserting that all OwnedPermissions contains `owned`"
            );

            $resource = Str::before($permission, '.');

            $this->assertStringStartsWith($resource, $permission);
            $this->assertContains($resource, $allResources);
        }
    }
}
