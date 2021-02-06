<?php

return [

    /**
     * All "Ownership Types", as they relate to the currently logged in User
     */
    "ownership_types" => [
        'owned',
        'team'
    ],

    /**
     * Any resource that can be "owned" by each "ownership_type"
     *  e.g. owned.user.browse 
     *    ...would be an example where we'd be checking if the currently logged in user has access to 'browse' the 'user' (or users) that they own
     * 
     * e.g. team.setting.edit 
     *   ... would be an example that checks if the logged in user has the ability to 'edit' the 'settings' for a 'team'    
     */
    "resources" => [
        "current_user",
        "user",
        "assignment",
        "setting",
        "billing",
        "notification",
        "permission",
        "guest",
        "client",
        "support",
        "field_member",
        "supervisor",
        "manager",
        "owner",
    ],

    /**
     * Often, a resource may have settings associated with it, such as "the settings for a user", o"the settings for a team", etc.
     *  ..turning this on will add an additional "type" that produces permission names for settings that are listed below...
     *   e.g. "_setting.owned.user.edit" would be an example of whether the logged-in user can edit the settings for any users that they own 
     */
    "use_settings_types" => true,

    /**
     * List all settings related items allowed. 
     * Each of these will produce a category for each "type" that is specified
     *  e.g. if "tenant" is added here, and "ownership_types" => ["owned", "team"], that would produce... 
     *      1. "_setting.owned.tenant.edit",
     *      2. "_setting.team.tenant.edit"
     * 
     */
    "settings" => [
        'tenant',
        'user',
        'campaign',
        'call_list',
        'contact',
        'dialer',
        'hopper',
        'phone_number',
        'contact',
        'follow_up',
    ]
];
