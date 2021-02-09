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
    public const SCOPE_ALL = '[all]';
    public const SCOPE_OWNED = '[owned]';
    public const SCOPE_TEAM = '[team]';
    public const SCOPE_OWNED_SETTING = '[owned_setting]';
    public const SCOPE_TEAM_SETTING = '[team_setting]';

    public const OWNERSHIP_SCOPES = [
        self::SCOPE_ALL,
        self::SCOPE_OWNED,
        self::SCOPE_OWNED_SETTING,
        self::SCOPE_TEAM,
        self::SCOPE_TEAM_SETTING,
    ];

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
        $this->ownedSettingPermissions = $this->ownedSettingPermissions();
        $this->teamSettingPermissions = $this->teamSettingPermissions();
        $this->allPermissions = $this->allPermissions();
    }

    public function byScope(string $scopeType)
    {
        if ($scopeType === self::SCOPE_ALL) return $this->allPermissions();

        if ($scopeType === self::SCOPE_TEAM) {
            return $this
                ->allPermissions()
                ->filter(
                    fn ($p) =>
                    Str::contains($p, '.' . self::SCOPE_TEAM . '.')
                );
        }

        if ($scopeType === self::SCOPE_OWNED) {
            return $this
                ->allPermissions()
                ->filter(
                    fn ($p) =>
                    Str::contains($p, '.' . self::SCOPE_OWNED . '.')
                );
        }

        if ($scopeType === self::SCOPE_OWNED_SETTING) {
            return $this
                ->allPermissions()
                ->filter(
                    fn ($p) =>
                    Str::contains($p, '.' . self::SCOPE_OWNED_SETTING . '.')
                );
        }

        if ($scopeType === self::SCOPE_TEAM_SETTING) {
            return $this
                ->allPermissions()
                ->filter(
                    fn ($p) =>
                    Str::contains($p, '.' . self::SCOPE_TEAM_SETTING . '.')
                );
        }

        throw new PermissionLookupException(
            "Unable to determine ownership type. Please instantiate using one of the facades/adapters so it can determined automatically."
        );
    }

    public function allPermissions(): Collection
    {
        return once(function () {
            return $this->ownedPermissions
                ->merge($this->ownedSettingPermissions->values())
                ->merge($this->teamPermissions->values())
                ->merge($this->teamSettingPermissions->values())
                ->unique()
                ->flatten();
        });
    }

    private function ownedPermissions()
    {
        return once(function () {
            return OwnedPermissionsFactory::all();
        });
    }

    private function ownedSettingPermissions()
    {
        return once(function () {
            return OwnedSettingPermissionsFactory::all();
        });
    }

    private function teamPermissions()
    {
        return once(function () {
            return TeamPermissionsFactory::all();
        });
    }

    private function teamSettingPermissions()
    {
        return once(function () {
            return TeamSettingPermissionsFactory::all();
        });
    }


    public static function allScopes(): array
    {
        return self::OWNERSHIP_SCOPES;
    }

    public function getScope(string $scopeName): array
    {
        return collect(self::OWNERSHIP_SCOPES)->first(fn ($s) => $s === $scopeName);
    }
}
