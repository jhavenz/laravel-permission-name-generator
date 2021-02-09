<?php


namespace Sourcefli\PermissionName\Adapters;

use Sourcefli\PermissionName\Contracts\RetrievesPermissions;
use Sourcefli\PermissionName\PermissionGenerator;
use Sourcefli\PermissionName\PermissionManager;

class AllPermissionsAdapter extends PermissionManager implements RetrievesPermissions
{
    public function setScope (string $scopeType): AllPermissionsAdapter
    {
        $this->validateScope($scopeType);

        $this->scopeType = $scopeType;

        return $this;
    }

    public function forOwned ()
    {
        return $this->setScope(PermissionGenerator::SCOPE_OWNED);
    }

    public function forOwnedSetting ()
    {
        return $this->setScope(PermissionGenerator::SCOPE_OWNED_SETTING);
    }

    public function forTeam ()
    {
        return $this->setScope(PermissionGenerator::SCOPE_TEAM);
    }

    public function forTeamSetting ()
    {
        return $this->setScope(PermissionGenerator::SCOPE_TEAM_SETTING);
    }



}