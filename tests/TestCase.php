<?php

namespace Sourcefli\PermissionName\Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Sourcefli\PermissionName\Factories\PermissionNameFactory;
use Sourcefli\PermissionName\Meta;
use Sourcefli\PermissionName\PermissionNameServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /** @var string */
    protected string $resource;

    /** @var string */
    protected string $settingsResource;

    /** @var array */
    protected array $meta;

    protected function setUp (): void
    {
        parent::setUp();

        $this->clearConfigFor(Meta::RESOURCES_PATH);
        $this->clearConfigFor(Meta::SETTINGS_PATH);

        Config::set(Meta::RESOURCES_PATH, [
            'user',
            'billing',
            'tenant',
            'agent',
            'manager'
        ]);

        Config::set(Meta::SETTINGS_PATH, [
            'email',
            'profile',
            'phone_numbers',
            'appointments',
            'addresses',
            'manager'
        ]);

        $resource = Meta::getResources();
        $idx = array_rand($resource);
        $this->resource = $resource[$idx];

        $settings = Meta::getSettings();
        $idx = array_rand($settings);
        $this->settingsResource = $settings[$idx];
    }

    protected function getPackageProviders($app)
    {
        return [
            PermissionNameServiceProvider::class
        ];
    }

//    protected function getEnvironmentSetUp($app)
//    {
//        // perform environment setup
//    }

    protected function clearConfigFor(string $configPath)
    {
        Config::set($configPath, []);
    }

    protected function allUserResources ()
    {
        return Meta::getResources();
    }

    protected function accessLevelCount ()
    {
        return count(PermissionNameFactory::allAccessLevels());
    }

    protected function resourceCount ()
    {
        return count(Meta::getResources());
    }

    protected function settingsResourcesCount ()
    {
        return count(Meta::getSettings());
    }

    protected function resourcePlusSettingsCount ()
    {
        return count(array_merge(
            Meta::getResources(),
            Meta::getSettings()
        ));
    }

    protected function basicScopes ()
    {
        return Meta::BASIC_SCOPES;
    }

    protected function settingScopes ()
    {
        return Meta::SETTING_SCOPES;
    }

    protected function basicScopesCount (): int
    {
        return count($this->basicScopes());
    }

    protected function settingScopesCount (): int
    {
        return count($this->settingScopes());
    }

    protected function scopesCount ()
    {
        return count($this->scopeTypes());
    }

    protected function scopeTypes ()
    {
        return array_merge(
            Meta::BASIC_SCOPES,
            Meta::SETTING_SCOPES
        );
    }

    /**
     * @param $permission
     * @return string
     */
    protected function extractResourceNameFromPermission ($permission)
    {
        return Str::before($permission, '.[');
    }

    protected function totalPermissionsForOneScope (string $ownershipType_ = '[owned]') //doc var
    {
        return $this->accessLevelCount()
            * $this->resourceCount();
    }
}
