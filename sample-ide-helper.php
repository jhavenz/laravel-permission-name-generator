<?php


/**
 * 
 * This file will always be different depending on the 'resources' and 'settings' that you've listed in your config.
 * But I love to have that ide assistance, though it takes extra time in the beginning. I love having it.
 * So here's a file that will give you a simple start on ide assistance
 * 
 * (create a 'permission_name_helper.php' in the root of your project...then add the following, replacing all methods with your resources/settings)
 */

/** =========================================================================================
 *  Section For 'resources' 
 *      - based on the following config: 
 *      [
 *          'resources' => [
 *              'user', 
 *              'billing'
 *          ],
 *  
 *          'settings' => [
 *              'user',
 *              'smtp'
 *          ]
 *      ] 
 * ========================================================================================== /



/** =======
 *  This section for the Facade Aliases (in the global namespace) 
 *      - each 'resources' listed in your config 
 * =======*/

/**
 *
 * @method static \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter setScope(string $scope)
 * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::setScope();
 *
 * @method static \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter setResource(string $resource)
 * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::setResource();
 * 
 * @method static \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter all()
 * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::all();
 *
 * @method static \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter user()
 * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::user();
 *
 * @method static \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter billing()
 * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::billing();
 */
class AllPermissions
{
}

/**
 * @method static \Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter all()
 * @see \Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter::all();
 *
 * @method static \Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter user()
 * @see \Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter::user();
 *
 * @method static \Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter billing()
 * @see \Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter::billing();
 *
 */
class OwnedPermission
{
}

/**
 * @method static \Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter all()
 * @see \Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter::all();
 * 
 * @method static \Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter user()
 * @see \Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter::user();
 *
 * @method static \Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter billing()
 * @see \Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter::billing();
 *
 */
class TeamPermission
{
}

/** =======
 *  This section for the Facade Aliases (in the global namespace) 
 *      - each 'settings' listed in your config 
 * =======*/

/**
 * @method static \Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter all()
 * @see \Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter::all();
 * 
 * @method static \Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter user()
 * @see \Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter::user();
 *
 * @method static \Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter smtp()
 * @see \Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter::smtp();
 */
class OwnedSettingPermission
{
}

/**
 * @method static \Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter all()
 * @see \Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter::all();
 * 
 * @method static \Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter user()
 * @see \Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter::user();
 *
 * @method static \Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter smtp()
 * @see \Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter::smtp();
 */
class TeamSettingPermission
{
}


/** =======
 *  And now the Facades (in the "\Illuminate\Support\Facades\..." namespace) 
 *      - each 'resources' listed in your config 
 * =======*/

namespace Illuminate\Support\Facades {

    use Sourcefli\PermissionName\Adapters\AllPermissionsAdapter;
    use Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter;

    /**
     *
     * @method static \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter setScope(string $scope)
     * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::setScope();
     *
     * @method static \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter setResource(string $resource)
     * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::setResource();
     * 
     * @method static \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter all()
     * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::all();
     *
     * @method static \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter user()
     * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::user();
     *
     * @method static \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter billing()
     * @see \Sourcefli\PermissionName\Adapters\AllPermissionsAdapter::billing();
     */
    class AllPermissions
    {
    }


    /**
     * @method static \Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter all()
     * @see \Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter::all();
     * 
     * @method static \Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter user()
     * @see \Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter::user();
     *
     * @method static \Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter billing()
     * @see \Sourcefli\PermissionName\Adapters\OwnedPermissionsAdapter::billing();
     */
    class OwnedPermission
    {
    }


    /**
     * @method static \Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter all()
     * @see \Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter::all();
     * 
     * @method static \Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter user()
     * @see \Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter::user();
     *
     * @method static \Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter billing()
     * @see \Sourcefli\PermissionName\Adapters\TeamPermissionsAdapter::billing();
     *
     */
    class TeamPermission
    {
    }


    /**
     * @method static \Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter all()
     * @see \Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter::all();
     * 
     * @method static \Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter user()
     * @see \Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter::user();
     *
     * @method static \Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter smtp()
     * @see \Sourcefli\PermissionName\Adapters\OwnedSettingPermissionsAdapter::smtp();
     */
    class OwnedSettingPermission
    {
    }


    /**
     * @method static \Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter all()
     * @see \Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter::all();
     * 
     * @method static \Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter user()
     * @see \Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter::user();
     *
     * @method static \Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter smtp()
     * @see \Sourcefli\PermissionName\Adapters\TeamSettingPermissionsAdapter::smtp();
     */
    class TeamSettingPermission
    {
    }
}
