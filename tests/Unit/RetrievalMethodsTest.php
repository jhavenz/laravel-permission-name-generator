<?php


use Sourcefli\PermissionName\Tests\TestCase;

class RetrievalMethodsTest extends TestCase
{

    /** @test */
    public function it_allows_the_all_method_on_any_facade()
    {
        $alls = [
            [\Sourcefli\PermissionName\Facades\AllPermissions::class, 'all'],
            [\Sourcefli\PermissionName\Facades\OwnedPermission::class, 'all'],
            [\Sourcefli\PermissionName\Facades\OwnedSettingPermission::class, 'all'],
            [\Sourcefli\PermissionName\Facades\TeamPermission::class, 'all'],
            [\Sourcefli\PermissionName\Facades\TeamSettingPermission::class, 'all'],
        ];

        foreach ($alls as $facade) {
            $this->assertInstanceOf(
                \Illuminate\Support\Collection::class,
                call_user_func($facade)
            );
        }
    }

}