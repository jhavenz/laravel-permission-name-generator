## Permission Name

A simple package to produce 'b.r.e.a.d.*' permissions for specified resources. All resources have a root 'category', and each category above that can have a "_settings" namespace added to its root.

Sick of writing out, remembering, and referencing a bunch of strings (as permissions) within Laravel apps?? Me too!!

Instead of constantly having to remember what the names of all the settings were, and remember the structure of hwo the permissions were created, my goal is for this package to just require the permissions to be declared once, within the config, then.. when needing to call/refernce the permissions that are the database, just be able to call specific methods (which an ide can help out with) that in turn will lookup the "permission name" that one is seeking to use.  

Some Examples:
```php
//config/permission-name.php

//using the following configs...

return [

    "ownership_types" => [
        'owned',
        'team'
    ],

    "resources" => [
        "user",
        "billing"
    ],

    "use_settings_types" => true,

    "settings" => [
        'contact',
        'follow_up',
    ]
];
```

Would produce the following permissions...

```php


//The facade/method to retrieve this string (provided by this package)...
OwnedPermission::user()->browse(); //=> returns 'user.owned.browse'
//i.e. Determines whether the current user can browse the users that they own within the application

//or another example...

TeamPermission::tenant()->edit(); //=> returns 'tenant.team.edit'
//i.e. Determines whether the current user can edit the tenant that their team is associated with in the application

//And examples for '_settings' permissions, which may be prepended in the permission name..

OwnedSettingPermission::user()->browse(); //=> returns '_setting.user.owned.browse'
//i.e. Determines whether the current user can browse the settings for the users that they own within the application

//vs
TeamSettingPermission::tenant()->edit(); //=> return '_setting.tenant.team.edit'
//i.e. Determines whether the current user can edit the tenant settings for the team theyre on within the application
```

- Note: all permission references are singular as well. This is because I can never remember which permissions have plural references and which don't...there's always at least 'one' of something though...