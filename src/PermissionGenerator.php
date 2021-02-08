<?php

namespace Sourcefli\PermissionName;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Sourcefli\PermissionName\Exceptions\PermissionLookupException;
use Sourcefli\PermissionName\Factories\OwnedPermissions as OwnedPermissionsFactory;
use Sourcefli\PermissionName\Factories\OwnedSettingPermissions as OwnedSettingPermissionsFactory;
use Sourcefli\PermissionName\Factories\TeamPermissions as TeamPermissionsFactory;
use Sourcefli\PermissionName\Factories\TeamSettingPermissions as TeamSettingPermissionsFactory;

class PermissionGenerator
{
    //V2
    protected Collection $ownedPermissions;
    protected Collection $teamPermissions;
    protected Collection $ownedSettingPermissions;
    protected Collection $teamSettingPermissions;
    protected Collection $allPermissions;

    //Previous
//    protected array $resources;
//    protected array $settings;
//
//    public Collection $abilities;
//    protected string $category;
//    protected string $type;

//    protected const OWNERSHIP_TYPES = [
//        "owned", "team", "owned_setting", "team_setting"
//    ];

    /**
     * TODO -
        => Aliases to composer.json
            "OwnedSettingPermission": "Sourcefli\\PermissionName\\Facades\\OwnedSettingPermission",
            "TeamPermission": "Sourcefli\\PermissionName\\Facades\\TeamPermission",
            "SettingPermission": "Sourcefli\\PermissionName\\Facades\\SettingPermission"
        => Factories
            "TeamPermission"
            "OwnedSettingPermission"
            "TeamSettingPermission"
     */

    public function __construct()
    {
        $this->ownedPermissions = $this->ownedPermissions();
        $this->teamPermissions = $this->teamPermissions();
        $this->ownedSettingPermissions = $this->ownedSettingPermissions ();
        $this->teamSettingPermissions = $this->teamSettingPermissions ();
        $this->allPermissions = $this->allPermissions();
    }

    public function allPermissions(): Collection
    {
        return once(function ()  {
            return $this->ownedPermissions
                ->merge($this->ownedSettingPermissions)
                ->merge($this->teamPermissions)
                ->merge($this->teamSettingPermissions)
                ->unique()
                ->flatten();
        });
    }

    private function ownedPermissions ()
    {
        return once(function ()  {
           return OwnedPermissionsFactory::all();
        });
    }

    private function ownedSettingPermissions ()
    {
        return once(function ()  {
           return OwnedSettingPermissionsFactory::all();
        });
    }

    private function teamPermissions ()
    {
        return once(function ()  {
           return TeamPermissionsFactory::all();
        });
    }

    private function teamSettingPermissions ()
    {
        return once(function ()  {
           return TeamSettingPermissionsFactory::all();
        });
    }

}
