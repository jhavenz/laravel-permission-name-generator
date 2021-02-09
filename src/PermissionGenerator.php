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
    
    public function __construct()
    {
        $this->ownedPermissions = $this->ownedPermissions();
        $this->teamPermissions = $this->teamPermissions();
        $this->ownedSettingPermissions = $this->ownedSettingPermissions ();
        $this->teamSettingPermissions = $this->teamSettingPermissions ();
        $this->allPermissions = $this->allPermissions();
    }

    public function byOwnershipType (string $ownershipType)
    {
        if ($ownershipType === 'all') return $this->allPermissions();

        if ($ownershipType === 'team') {
            return $this
                ->allPermissions()
                ->filter(
                    fn ($p) =>
                        !Str::startsWith($p, 'team') &&
                        !Str::contains($p, '_setting') &&
                        Str::contains($p, '.team.')
                );
        }

        if ($ownershipType === 'owned') {
            return $this
                ->allPermissions()
                ->filter(
                    fn ($p) =>
                        !Str::startsWith($p, 'owned') &&
                        !Str::contains($p, '_setting') &&
                        Str::contains($p, '.owned.')
                );
        }

        if ($ownershipType === 'owned_setting') {
            return $this
                ->allPermissions()
                ->filter(
                    fn ($p) =>
                        Str::startsWith($p, '_setting') &&
                        Str::contains($p, '.owned.')
                );
        }

        if ($ownershipType === 'team_setting') {
            return $this
                ->allPermissions()
                ->filter(
                    fn ($p) =>
                        Str::startsWith($p, '_setting') &&
                        Str::contains($p, '.team.')
                );
        }

        throw new PermissionLookupException(
            "Unable to determine ownership type. Please instantiate using one of the facades/adapters so it can determined automatically."
        );
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
