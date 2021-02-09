<?php

namespace Sourcefli\PermissionName\Tests\Feature;

use Sourcefli\PermissionName\Facades\AllPermissions;
use Sourcefli\PermissionName\Facades\OwnedPermission;
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
    public function it_allows_resource_methods_to_be_called_on_the_facade()
    {
        $expected = 'user.owned.force_delete';
        $perm = OwnedPermission::user()->force_delete();

        dump($perm);
        $this->assertSame($expected, $perm, "Failed asserting that {$perm} is equal to {$expected}");
    }
}
