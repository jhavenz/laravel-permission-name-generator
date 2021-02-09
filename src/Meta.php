<?php


namespace Sourcefli\PermissionName;


class Meta
{
    public const CONFIG_BASE_PATH = 'permission-name-generator';

    public const CONFIG_FILENAME = self::CONFIG_BASE_PATH . '.php';

    public const RESOURCES_PATH = self::CONFIG_BASE_PATH .'.resources';

    public const SETTINGS_PATH = self::CONFIG_BASE_PATH .'.settings';

    public const BASIC_SCOPES = [
        'OwnedPermission', 'TeamPermission'
    ];

    public const SETTING_SCOPES = [
        'OwnedSettingPermission', 'TeamSettingPermission'
    ];

    public static function getResources ()
    {
        return config(self::RESOURCES_PATH);
    }

    public static function getSettings ()
    {
        return config(self::SETTINGS_PATH);
    }

}