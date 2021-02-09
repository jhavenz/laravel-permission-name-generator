## Laravel Permission Name Generator

### Warning: This package is still a work in progress!!
!! **PLEASE DO NOT** use this package in a production environment yet !!

**Contributions Are Welcome**
Anyone's thats willing to help 'use it in the wild' is welcome! 
I'm currently doing this in some of my own projects over the next few months as well.
    - __Anyone who's good at generating doc blocks programatically would **very welcome** to add a command that generates the doc blocks for the Facades in this package!__

### Intro
Create and Retrieve permission strings using methods instead of strings, and a very simple configuration.

Each item listed in the config will get a 'permission set', one of each:

- browse
- read
- edit
- add
- delete
- restore
- force_delete
- `*` _(referenced using the 'wildcard' method)_

### Note:
**This package is a glorified getter/setter for permission strings. Providing convenience and convention.

**_There is ZERO logic when the time comes to AUTHORIZE ANYTHING throughout your app. This is an entirely seperate matter._**

**All package logic is related to generating 'permission strings' very easily and retrieving them, very eaasily, throughout your app.**

---
## Quick Start
I've been using Spatie's 'Spatie Permissions' package a lot lately and got pretty annoyed with always having to remember which permissions were plural, which syntax allowed the user to view 'team' permissions (though I had a 'Team' model, so it had to be something besides 'team' or 'teams'), vs which permissions were just for the user's own resources. On top of that, having to hard code permission strings throughout the application, or create a wrapper each time. 
It seemed like such a common routine, I has to venture out and create a package, albeit my first public package. 
_So please go easy on me guys, if you find any issue. I'm willing and open to any **constructive** criticism_

This package is an effort to create a convention to naming, generating, and accessing predictable and reliable permission strings, and  

### Installation
```bash
composer require sourcefli/laravel-permission-name-generator
```
---

### Publish Config
```bash
php artisan vendor:publish --provider="Sourcefli\PermissionName\PermissionNameServiceProvider"
```
---

### Add Resources/Settings To Config File
```php
//=> config/permission-name-generator

//For the quickstart, just add a couple resources
return [

    'resources' => [
        'user',
        'billing',
        'tenant'
    ]

];
```

### Now Use It
This example might be the permission used when you want to know if:
_The current user can edit the billing settings THEY OWN in the application_
```php
//=> web.php
use Sourcefli\PermissionName\Facades\OwnedPermission;

Route::get('permissions', function () {
    OwnedPermission::billing()->edit();
    //returns 'billing.[owned].edit'
});
```
**or**

This example might be the permission used when you want to know if:
_The current user can edit the smtp settings for THEIR ENTIRE TEAM_
```php
//=> web.php

//note the Facade change
use Sourcefli\PermissionName\Facades\TeamPermission;

Route::get('permissions', function () {
    TeamPermission::smtp()->edit();
    //returns 'smtp.[team].edit' 
});
```
---

### 'Settings' Quick Start
The 'settings' section in the config file is optional.
This is added in the case that you have 'settings' related permissions that are seperate from your resources.
```php
//=> config/permission-name-generator

return [

    'resources' => [
        ...
    ],

    'settings' => [
        'user', //can be 'settings' related a model in your app...
        'smtp', //or any random 'settings' that your app uses..
    ]
];
```

### Now Use It
This example might be the permission used when you want to know if:
The current User can edit THEIR OWN smtp settings...
```php
//=> web.php

//note the Facade change
use Sourcefli\PermissionName\Facades\OwnedSettingPermission;

Route::get('permissions', function () {
    OwnedSettingPermission::smtp()->edit();
    //returns 'smtp.[owned_setting].edit' 
});
```
or

This example might be the permission used when you want to know if:
The current User can edit THEIR TEAMS smtp settings (or any smtp settings owned by their THEIR TEAM)
```php
//=> web.php

//note the Facade change
use Sourcefli\PermissionName\Facades\TeamSettingPermission;

Route::get('permissions', function () {
    TeamSettingPermission::smtp()->edit();
    //returns 'smtp.[team_setting].edit' 
});
```
Any distinction between the 'team' scope and the 'owned' scope is open to interpretation as is needed for your app, of course. I'm just listing out some examples of how I've used these permission strings before.
---

### Retrieval 'all' Permissions
This example provides access to ALL permissions available ('resources' and 'settings' combined):
```php
//=> web.php
use Sourcefli\PermissionName\Facades\AllPermissions;

Route::get('permissions', function () {
    AllPermissions::all();
    //returns an Laravel Collection of all available permissions that were generated
});
```
This example returns all 'resources' within the 'owned' scope: 
_(see below for further explanation on 'scope')_ 
```php
//=> web.php
use Sourcefli\PermissionName\Facades\OwnedPermission;

Route::get('permissions', function () {
    OwnedPermission::all();
    //returns an Laravel Collection of all 'resource' permissions within the 'owned' scope
});
```
---

This package comes with 5 of these facades, each has their own 'scope' which I'll talk about further below.
```php
use Sourcefli\PermissionName\Facades\AllPermissions;
use Sourcefli\PermissionName\Facades\OwnedPermission;
use Sourcefli\PermissionName\Facades\OwnedSettingPermission;
use Sourcefli\PermissionName\Facades\TeamPermission;
use Sourcefli\PermissionName\Facades\TeamSettingPermission;
```

You can also use the root aliases...

```php 
use AllPermissions;
use OwnedPermission;
//and so on..
```


### Quick Examples:
```php
use OwnedPermission;
 
/**
 * This example might be the permission that you reference to see if the current user can browse their own users within the application
 * Note: no plurals are used in any permissions in effort to stick to a convention
 */ 
OwnedPermission::user()->browse(); 
//returns 'user.[owned].browse'
```

```php
use Sourcefli\PermissionName\Facades\TeamPermission;
 
/**
 * This example might be the permission that you reference to see if the current user has 'team access' to delete users
 */
TeamPermission::user()->delete(); 
//returns 'user.[team].delete'
```

####_Opt-in_
'Settings' feature...
* The 'settings' permissions can be associated with your models or be a standalone set of permissions for any name you'd like to provide...
* Using the same references as above, just take note of the different facades being used:
```php
use OwnedSettingPermission;
 
/**
 * This example might be the permission that you reference to see if the current user 
 * can delete the THEIR SETTINGS within the application
 */ 
OwnedSettingPermission::user()->delete(); 
//returns 'user.[owned_setting].delete'


/**
 * Or it can reference something completely random, up to you..
 * 
 * This example might be the permission that you reference to see if the current user 
 * can edit the settings for THEIR smtp configuration within the application
 */
OwnedSettingPermission::smtp()->edit();
//returns 'smtp.[owned_setting].edit'
```

Also, there's a `TeamSettingPermission` facade which I use to reference whether the user
has access to TEAM SETTINGS for a particular thing:

```php
use TeamSettingPermission;

/**
 * This similar example might be the permission that you reference to see if the current user 
 * can edit the smtp settings for their entire team within the application
 */ 
TeamSettingPermission::smtp()->edit(); 
//returns 'smtp.[team_setting].edit'
```

---

## How it Works

**Step 1:**

In the config, list any resource-related items that you'd like to have permission sets for.
When I say 'permission set', I'm referring to the 'b.r.e.a.d.r.f.*' acronym that's listed above.

For example:
```php
//=> config/permission-name-generator.php
return [
    "resources" => [
        "user",
        "billing"
    ],
];
```

Adding those two items to the config would generate the following 'permission sets'
```php
[
    "user.[owned].browse",
    "user.[owned].read",
    "user.[owned].edit",
    "user.[owned].add",
    "user.[owned].delete",
    "user.[owned].restore",
    "user.[owned].force_delete",
    "user.[owned].*",
    "billing.[owned].browse",
    "billing.[owned].read",
    "billing.[owned].edit",
    "billing.[owned].add",
    "billing.[owned].delete",
    "billing.[owned].restore",
    "billing.[owned].force_delete",
    "billing.[owned].*",
    "user.[team].browse",
    "user.[team].read",
    "user.[team].edit",
    "user.[team].add",
    "user.[team].delete",
    "user.[team].restore",
    "user.[team].force_delete",
    "user.[team].*",
    "billing.[team].browse",
    "billing.[team].read",
    "billing.[team].edit",
    "billing.[team].add",
    "billing.[team].delete",
    "billing.[team].restore",
    "billing.[team].force_delete",
    "billing.[team].*",
];
```

**Step 2:**
Each resource listed in the config file will allow you to call it (by the same name) on each of the facades.

_with the exception of the `AllPermissions` facade, which I'll get to at the end._

For Example, these methods can now be called:
```php
use OwnedPermission;
use TeamPermission;


OwnedPermission::user();
//..or 
TeamPermission::billing();
//but keep reading, because you dont want to call these alone
```

You can now use these methods to chain 'retreival' methods in order to hunt down the permission string you're after:
```php
use OwnedPermission;
use TeamPermission;


OwnedPermission::user()->create();
//returns 'user.[owned].create'

OwnedPermission::user()->edit();
//returns 'user.[owned].edit'

TeamPermission::billing()->edit();
//returns 'billing.[team].edit'

/**
* Or, using the 'wildcard' method..
 */
TeamPermission::billing()->wildcard();
//returns 'billing.team.*'
```

These 'retrieval' methods are all listed in [this contract](https://github.com/Sourcefli/laravel-permission-name-generator/blob/main/src/Contracts/RetrievesPermissions.php).

Essential, for each resource in the config, you can call any of these:
```php
use OwnedPermission;
use TeamPermission;

//=> allows you to call all the following 'retrieval' methods:
OwnedPermission::user()->browse(); //returns 'user.[owned].browse'
OwnedPermission::user()->read(); //returns 'user.[owned].read'
OwnedPermission::user()->add(); //returns 'user.[owned].add'
OwnedPermission::user()->edit(); //returns 'user.[owned].edit'
OwnedPermission::user()->delete(); //returns 'user.[owned].delete'
OwnedPermission::user()->restore(); //returns 'user.[owned].restore'
OwnedPermission::user()->force_delete(); //returns 'user.[owned].force_delete'
OwnedPermission::user()->wildcard(); //returns 'user.[owned].*'

//This will work on any of the facades...
//Using the same config, you also have these methods available:
TeamPermission::user()->browse(); //returns 'user.[team].browse'
TeamPermission::user()->read(); //returns 'user.[team].read'
TeamPermission::user()->add(); //returns 'user.[team].add'
TeamPermission::user()->edit(); //returns 'user.[team].edit'
TeamPermission::user()->delete(); //returns 'user.[team].delete'
TeamPermission::user()->restore(); //returns 'user.[team].restore'
TeamPermission::user()->force_delete(); //returns 'user.[team].force_delete'
TeamPermission::user()->wildcard(); //returns 'user.[team].*'
```

**Step 3:**

The optional 'settings' within the config file can be added.
These work on the same way, but there's separate Facades to interact with them:

For example:
```php
//=> config/permission-name-generator.php
return [
    "resources" => [
        ...
    ],
    
    
    "settings" => [
        'server', // maybe some model that has settings related to it.. 
        'smtp', // or some random thing that may require settings in your application
    ]
];
```

Adding those two items to the 'settings' in the config file would generate the following 'permission sets'
```php
[
    "server.[owned_setting].browse",
    "server.[owned_setting].read",
    "server.[owned_setting].edit",
    "server.[owned_setting].add",
    "server.[owned_setting].delete",
    "server.[owned_setting].restore",
    "server.[owned_setting].force_delete",
    "server.[owned_setting].*",
    "smtp.[owned_setting].browse",
    "smtp.[owned_setting].read",
    "smtp.[owned_setting].edit",
    "smtp.[owned_setting].add",
    "smtp.[owned_setting].delete",
    "smtp.[owned_setting].restore",
    "smtp.[owned_setting].force_delete",
    "smtp.[owned_setting].*",
    "server.[team_setting].browse",
    "server.[team_setting].read",
    "server.[team_setting].edit",
    "server.[team_setting].add",
    "server.[team_setting].delete",
    "server.[team_setting].restore",
    "server.[team_setting].force_delete",
    "server.[team_setting].*",
    "smtp.[team_setting].browse",
    "smtp.[team_setting].read",
    "smtp.[team_setting].edit",
    "smtp.[team_setting].add",
    "smtp.[team_setting].delete",
    "smtp.[team_setting].restore",
    "smtp.[team_setting].force_delete",
    "smtp.[team_setting].*",
];
```

And, just like resources, you can now can these on the related Facade:
```php
use OwnedSettingPermission;
use TeamSettingPermission;

//=> One Facade is related to the users own 'settings' access:
OwnedSettingPermission::server()->browse(); //returns 'server.[owned_setting].browse'
OwnedSettingPermission::server()->read(); //returns 'server.[owned_setting].read'
OwnedSettingPermission::server()->add(); //returns 'server.[owned_setting].add'
OwnedSettingPermission::server()->edit(); //returns 'server.[owned_setting].edit'
OwnedSettingPermission::server()->delete(); //returns 'server.[owned_setting].delete'
OwnedSettingPermission::server()->restore(); //returns 'server.[owned_setting].restore'
OwnedSettingPermission::server()->force_delete(); //returns 'server.[owned_setting].force_delete'
OwnedSettingPermission::server()->wildcard(); //returns 'server.[owned_setting].*'

//Or you can use the 'team settings' by calling this facade:
TeamSettingPermission::smtp()->browse(); //returns 'smtp.[team_setting].browse'
TeamSettingPermission::smtp()->read(); //returns 'smtp.[team_setting].read'
TeamSettingPermission::smtp()->add(); //returns 'smtp.[team_setting].add'
TeamSettingPermission::smtp()->edit(); //returns 'smtp.[team_setting].edit'
TeamSettingPermission::smtp()->delete(); //returns 'smtp.[team_setting].delete'
TeamSettingPermission::smtp()->restore(); //returns 'smtp.[team_setting].restore'
TeamSettingPermission::smtp()->force_delete(); //returns 'smtp.[team_setting].force_delete'
TeamSettingPermission::smtp()->wildcard(); //returns 'smtp.[team_setting].*'
```

## The `AllPermissions` Facade
This facade works a little differently, though just a small difference.
If want to get a collection of all your permissions, you can call `AllPermission::all()` directly on this facade.
This will give you a combined Collection of 'resources' and 'settings' that you've listed in your config file..

**Note:**
If you want to retrieve permission strings from this Facade, it's a little different from the others.
First, you have set a `scope`, then you can chain the standard methods as listed above (check out the tests [starting here](https://github.com/Sourcefli/laravel-permission-name-generator/tree/main/tests/Feature/AllPermissions) for sample usage).
There are 4 methods available on this Facade to do this with: 

```php
use AllPermissions;

AllPermissions::forOwned();
AllPermissions::forTeam();
AllPermissions::forOwnedSetting();
AllPermissions::forTeamSetting();

//Once you call any of these methods, you can then chain the methods listed above as usual..
// for Example:
AllPermissions::forTeamSetting()->server()->edit();

//or 

AllPermissions::forOwned()->billing()->delete();
```

### For All Facades:
You can call the `all()` method on any of the Facades in order to get a complete list of permissions that are within that scope.
For Example:
```php

use Sourcefli\PermissionName\Facades\AllPermissions;
use Sourcefli\PermissionName\Facades\OwnedPermission;
use Sourcefli\PermissionName\Facades\TeamSettingPermission;

OwnedPermission::all();
// returns all 'resource' permissions in the '[owned]' scope

TeamSettingPermission::all();
// returns all 'settings' permissions in the '[team_setting]' scope 
//...the same goes for the 'TeamPermission' and 'OwnedSettingPermission' Facades 
 
//lastly...to get a Collection of all available permissions
AllPermissions::all();
// returns all 'resources' and 'settings' permissions available..
// aka ALL permissions
```

### A Couple Notes: 

1. **What are the brackets for on each permission string?**
This is to prevent any naming clashes with the 'resources' and 'settings' that you have listed in your config file.
If you're looking at the source code, these are often referred to as `ownershipScopes` or just `scopes`

2. **Why Is Everything Singular?**
This is definitely intentional, since when I'm working on my own projects, I was always having to lookup what was singular and what wasn't.
The `AllPermissions` Facade is the only thing that's singular (unless I overlooked something somewhere, if so please let me know).
This provides a unified and predictable format across the board... 

3. **Can I add my own scopes?**
No, right now there's only 4 available... as represented by the Facades.
   
4. **Can Permissions be queried in any way?**
Only if you've saved the permissions to your database, then you can use your ORM.
This package is only intended to either return an \Illuminate\Support\Collection of 
permissions (either scoped, or all permissions, using the `AllPermissions` Facade).
or to retrieve a single permission as a string. 
I plan to add the `only()` and `except()` methods (like [Spatie's Data Transfer Object Package](https://github.com/spatie/data-transfer-object))
but that's as fancy as the methods will get. I intend to keep this package as simple as possible.


#### This package is still a work in progress!! Please dont use in any production environment yet!