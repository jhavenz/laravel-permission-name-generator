<?php


namespace Sourcefli\PermissionName\Adapters;

use Sourcefli\PermissionName\Contracts\RetrievesPermissions;
use Sourcefli\PermissionName\PermissionManager;

class OwnedPermissionsAdapter extends PermissionManager implements RetrievesPermissions
{}