<?php


use Jhavenz\PermissionName\Tests\TestCase;

class RetrievalMethodsTest extends TestCase
{

    /** @test */
    public function it_allows_the_all_method_on_any_facade()
    {
        $alls = [
            [\Jhavenz\PermissionName\Facades\AllPermissions::class, 'all'],
            [\Jhavenz\PermissionName\Facades\OwnedPermission::class, 'all'],
            [\Jhavenz\PermissionName\Facades\OwnedSettingPermission::class, 'all'],
            [\Jhavenz\PermissionName\Facades\TeamPermission::class, 'all'],
            [\Jhavenz\PermissionName\Facades\TeamSettingPermission::class, 'all'],
        ];

        foreach ($alls as $facade) {
            $this->assertInstanceOf(
                \Illuminate\Support\Collection::class,
                call_user_func($facade)
            );
        }
    }

}
