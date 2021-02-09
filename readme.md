### This package is still a work in progress!! 
#### Anyone is welcome to contribute 

!! **PLEASE DO NOT** use this package other than in a local environment !!


## Laravel Permission Name Generator

A simple package to create/reference permission strings for specified resources. 

_b.r.e.a.d.r.f.* definition_
- browse
- read
- edit
- add
- delete
- restore
- force_delete
- `*` _(referenced using the 'wildcard' method)_

### Note:
**This is a glorified getter/setter for permission strings. 

**_There is no logic when is comes authorization logic._**

**All logic is related to creating 'permission strings' and retrieving them.**

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

### 'Retrieval' Methods
When I mention this, I'm referring to the methods that are listed in [this contract](https://github.com/Sourcefli/laravel-permission-name-generator/blob/main/src/Contracts/RetrievesPermissions.php).

For each resource that you list in the config file, you can:

1. Call that resource (by name) on the facade
`OwnedPermission::user()`
   
2. Then you can chain the 'retrieval' method on the call to the resource, e.g.
`OwnedPermission::user()->browse()`

3. This means, for each resource that you've listed within the config, you have 9 'retrieval' methods you can call:
```php
//=> config/permission-name
return [
    'resources' => [
        'user'
    ]
];

//=> allows you to call all the following 'retrieval' methods:
OwnedPermission::user()->browse(); //returns 'user.owned.browse'
OwnedPermission::user()->read(); //returns 'user.owned.read'
OwnedPermission::user()->add(); //returns 'user.owned.add'
OwnedPermission::user()->edit(); //returns 'user.owned.edit'
OwnedPermission::user()->delete(); //returns 'user.owned.delete'
OwnedPermission::user()->restore(); //returns 'user.owned.restore'
OwnedPermission::user()->force_delete(); //returns 'user.owned.force_delete'
OwnedPermission::user()->wildcard(); //returns 'user.owned.*'

//This will work on any of the facades...
//Using the same config, you also have these methods available:
TeamPermission::user()->browse(); //returns 'user.team.browse'
TeamPermission::user()->read(); //returns 'user.team.read'
TeamPermission::user()->add(); //returns 'user.team.add'
TeamPermission::user()->edit(); //returns 'user.team.edit'
TeamPermission::user()->delete(); //returns 'user.team.delete'
TeamPermission::user()->restore(); //returns 'user.team.restore'
TeamPermission::user()->force_delete(); //returns 'user.team.force_delete'
TeamPermission::user()->wildcard(); //returns 'user.team.*'

//the same applies for the other facades, which are:
OwnedSettingPermission::class;
TeamSettingPermission::class;
AllPermission::class;
```


#### This package is still a work in progress!! Please dont use in production!