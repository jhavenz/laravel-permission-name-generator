<?php

return [

    /**
     * Any resource that you want to generate permissions for
     *  e.g. listing 'user' here would generate the following permission set...
     *      - 'user.[owned].browse'
     *      - 'user.[owned].read'
     *      - 'user.[owned].edit'
     *      - 'user.[owned].add'
     *      - 'user.[owned].delete'
     *      - 'user.[owned].restore'
     *      - 'user.[owned].force_delete'
     *      - 'user.[owned].*'
            AND..
     *      - 'user.[team].browse'
     *      - 'user.[team].read'
     *      - 'user.[team].edit'
     *      - 'user.[team].add'
     *      - 'user.[team].delete'
     *      - 'user.[team].restore'
     *      - 'user.[team].force_delete'
     *      - 'user.[team].*'
     *
     * [owned] and [team] represent 'permission scopes' which, as an example, would mean:
     *      'user.[owned].browse' -> determines if the current user can browse any user(s) THEY OWN within the application
     *      'user.[team].browse' -> determines if the current user can browse any user(s) THEIR TEAM OWNS within the application
     */
    "resources" => [
        "user",
        "billing",
    ],

    /**
     * List all setting-related items allowed (optional)
     * If you need a sub-category for 'settings' on each resource, this would provide that option.
     *
     * Each of these will produce two additional 'permission scopes', one for each setting listed
     *  e.g. listing "follow_ups" here would generate the following permission set..
     *      - 'follow_up.[owned_setting].browse'
     *      - 'follow_up.[owned_setting].read'
     *      - 'follow_up.[owned_setting].edit'
     *      - 'follow_up.[owned_setting].add'
     *      - 'follow_up.[owned_setting].delete'
     *      - 'follow_up.[owned_setting].restore'
     *      - 'follow_up.[owned_setting].force_delete'
     *      - 'follow_up.[owned_setting].*'
    AND..
     *      - 'follow_up.[team_setting].browse'
     *      - 'follow_up.[team_setting].read'
     *      - 'follow_up.[team_setting].edit'
     *      - 'follow_up.[team_setting].add'
     *      - 'follow_up.[team_setting].delete'
     *      - 'follow_up.[team_setting].restore'
     *      - 'follow_up.[team_setting].force_delete'
     *      - 'follow_up.[team_setting].*'
     *
     * [owned_setting] and [team_setting] represent 'permission scopes' as well which, as an example, would mean:
     *      'follow_up.[owned_setting].browse' -> determines if the current user can browse the settings for a 'follow_up' THEY OWN within the application
     *      'follow_up.[team_setting].browse' -> determines if the current user can browse the settings for any 'follow_up' THEIR TEAM OWNS within the application
     * 
     */
    "settings" => [
        'follow_up',
        'emails',
    ]
];
