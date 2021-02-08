### This package is still a work in progress!! 
!! Please do NOT use in production !!

## Laravel Permission Name Generator

A simple package to produce 'b.r.e.a.d.r.f.*' permissions for specified resources. All resources have a root 'category', and each category above that can have a "_settings" namespace added to its root.

_b.r.e.a.d.r.f.* definition_
- browse
- read
- edit
- add
- delete
- restore
- force_delete
- `*` _(referenced as 'wildcard')_

### Note:
##### This is a glorified getter/setter for permission strings. There is no logic when is comes authorization logic.
##### All logic is related to creating 'permission strings' and retrieving them.

I've been using Spatie's 'Spatie Permissions' package a lot lately and quickly got annoyed at always having to remember what was plural, and what the exact permissions name was. 

This package is an effort to create a convention to naming and retrieving permissions (while not hard-coding them throughout the app as well). 
There had to be a better way...

This package comes with 5 facades:

`AllPermission::class`

`OwnedPermission::class`

`OwnedSettingPermission::class`

`TeamPermission::class`

`TeamSettingPermission::class`

### Quick Example Usage:
```php
/**
 * This example might be the permission that you reference to see if the current user can browse their own users within the application
 * Note: no plurals are used in any permissions in effort to stick to a convention
 */
OwnedPermission::user()->browse(); 
//returns 'owned.user.browse'
```

```php
/**
 * This example might be the permission that you reference to see if the current user has 'team access' to delete users
 */
TeamPermission::user()->delete(); 
//returns 'team.user.delete'
```

```php
/**
 * Since each model may have settings associated with them which users may/may not have access to, I've added the same type of logic but prepended '_setting.*' to them.
 * Using the same references as above, but for the settings of each..
 * 
 * This example might be the permission that you reference to see if the current user can browse the settings for "their user's"  within the application
 */
OwnedSettingPermission::user()->browse(); 
//returns '_setting.owned.user.delete'
```

```php
/**
 * Lastly, similar to 'owned', but for 'team access' to be able to edit settings for the current user's users'. 
 * 
 * This example might be the permission that you reference to see if the current user can browse the settings for "their user's"  within the application
 */
TeamSettingPermission::user()->edit(); 
//returns '_setting.team.user.edit'
```


---

### Generating Permissions

In the config, you just need to add each resource that you plan to have permissions for...

For example:

```php
//=> config/permission-name.php

return [

    "resources" => [
        "user",
        "billing"
    ],
];
```

Adding those two simple items to the config would produce the following permissions...
```php
//Now, if using the Facade to get all permissions...
AllPermission::all();
//returns an array of permissions generated 
[
    "user.owned.browse",
    "user.owned.read",
    "user.owned.edit",
    "user.owned.add",
    "user.owned.delete",
    "user.owned.restore",
    "user.owned.force_delete",
    "user.owned.*",
    "billing.owned.browse",
    "billing.owned.read",
    "billing.owned.edit",
    "billing.owned.add",
    "billing.owned.delete",
    "billing.owned.restore",
    "billing.owned.force_delete",
    "billing.owned.*",
    "user.team.browse",
    "user.team.read",
    "user.team.edit",
    "user.team.add",
    "user.team.delete",
    "user.team.restore",
    "user.team.force_delete",
    "user.team.*",
    "billing.team.browse",
    "billing.team.read",
    "billing.team.edit",
    "billing.team.add",
    "billing.team.delete",
    "billing.team.restore",
    "billing.team.force_delete",
    "billing.team.*",
];
```

This provides you with two methods to call on each Facade (one for each resource).

`user()`
and 
`billing()`

Then chain the 'retrieval' methods from there, such as...
```php
OwnedPermission::user()->create();
//returns 'user.owned.create'

OwnedPermission::user()->edit();
//returns 'user.owned.edit'

TeamPermission::billing()->edit();
//returns 'billing.team.edit'

/**
* Using the `wildcard` method..
 */
TeamPermission::billing()->wildcard();
//returns 'billing.team.*'
```


#### This package is still a work in progress!! Please dont use in production!