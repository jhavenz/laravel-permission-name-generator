<?php


namespace Jhavenz\PermissionName\Adapters;

use Illuminate\Support\Str;
use Jhavenz\PermissionName\Factories\AllPermissions as AllPermissionsFactory;
use Jhavenz\PermissionName\PermissionManager;
use Jhavenz\PermissionName\PermissionGenerator;
use Jhavenz\PermissionName\Contracts\RetrievesPermissions;

class AllPermissionsAdapter extends PermissionManager implements RetrievesPermissions
{
    public function setScope(string $scopeType): PermissionManager
    {
        $scope = Str::of($scopeType);

        if (!$scope->startsWith('[')) {
            $scope = $scope->prepend('[');
        }

        if (!$scope->endsWith(']')) {
            $scope = $scope->append(']');
        }

        $this->validateScope((string) $scope);

        return AllPermissionsFactory::makeAdapter($scope);
    }

    public function forOwned()
    {
        return $this->setScope(PermissionGenerator::SCOPE_OWNED);
    }

    public function forOwnedSetting()
    {
        return $this->setScope(PermissionGenerator::SCOPE_OWNED_SETTING);
    }

    public function forTeam()
    {
        return $this->setScope(PermissionGenerator::SCOPE_TEAM);
    }

    public function forTeamSetting()
    {
        return $this->setScope(PermissionGenerator::SCOPE_TEAM_SETTING);
    }
}
