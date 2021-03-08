
## Laravel Permission Name Generator

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


### Quick Example
Adding one item within the `resources` array in your config, such as...
```php
//=> config.php
<?php

return [
    'resources' => [
        'billing'
    ]
];
```
Produces the following permission strings...
_Note: each item wrapped in brackets, e.g. [owned], is considered a 'scope'_
```php
'billing.[owned].browse'
'billing.[owned].read' 
'billing.[owned].edit' 
'billing.[owned].add' 
'billing.[owned].delete' 
'billing.[owned].restore' 
'billing.[owned].force_delete'
'billing.[owned].*'
//and
'billing.[team].browse'
'billing.[team].read' 
'billing.[team].edit' 
'billing.[team].add' 
'billing.[team].delete' 
'billing.[team].restore' 
'billing.[team].force_delete'
'billing.[team].*'
```
An example to access one of these permission strings in your Laravel app...
```php
//=> anywhere in your app

OwnedPermission::billing()->edit(); 
/**
* returns: 
*   'billing.[owned].edit'
*/ 

//Or, with global helper functions..

ownedPermission('billing')->read(); 
/**
* returns: 
*   'billing.[owned].read'
*/ 
```

Examples to grab subsets of permissions for a `resource`:
```php

//Or, 'only' a subset for a specific scope..

teamPermission('billing')->only(['browse', 'edit']);
/**
* returns: 
*    [ //Laravel Collection
*        'billing.[team].browse',
*        'billing.[team].edit'
*    ]
*/ 

//Or, 'except' a subset for a specific scope..

teamPermission('billing')->except(['force_delete', 'restore']);
/**
* returns: 
*   [ //Laravel Collection
*        'billing.[team].browse',
*        'billing.[team].read',
*        'billing.[team].edit',
*        'billing.[team].add',
*        'billing.[team].delete',
*        'billing.[team].*' // <-- be careful when using 'except'... the '*' permission must be expicitly excluded
*    ]
*/ 

```

### Authorization Note:
**This package is a glorified getter/setter for permission strings. Providing convenience and convention.

**_There is ZERO logic when the time comes to AUTHORIZING ANYTHING throughout your app. This is an entirely seperate matter._**

**All package logic is related to generating 'permission strings' very easily and retrieving them very easily throughout your app. Convention and Predictability are at the heart of what this package provides.**

---
## Overview
I've been using Spatie's [Spatie Permissions](https://github.com/spatie/laravel-permission) package a lot lately and got pretty annoyed with always having to remember which permissions were plural, which syntax allowed the user to view 'team' permissions (though I had a 'Team' model, so it had to be something besides 'team' or 'teams'), vs which permissions were just for the user's own resources. On top of that, having to hard code permission strings throughout the application, or create a wrapper each time. 
It seemed like such a common routine, I decided to venture out and create a package for this.

_Please let me know if you find any issues. I'm glad to make any updates that are required._

### TLDR;
Package provides conventions for naming, generating, and referencing permission strings in a predictable and dynamic manner 
(never hard-coding permission strings throughout your app). 

---

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
        '...'
    ],

    'settings' => [
        //explained in next section
        '...'
    ]

];

```
Note: See [QA Section](https://github.com/Sourcefli/laravel-permission-name-generator#qa) at bottom of this readme to see why brackets are used and a couple other questions you might have

### Now Use It
This example might be the permission used when you want to know if:

_The current user can edit the billing settings THEY OWN in the application_
```php
//=> routes/web.php
use Sourcefli\PermissionName\Facades\OwnedPermission;

Route::get('permissions', function () {
    OwnedPermission::billing()->edit();
    //returns 'billing.[owned].edit'
});

//or, get all 'resources' now available to you:
Route::get('permissions', function () {
    return collect([OwnedPermission::all(), TeamPermission::all()])->toArray();
});
```
**or**

This example might be the permission used when you want to know if:

_The current user can edit the billing settings THEIR TEAM OWNS, or ANYONE ON THEIR TEAM OWNS (just throwing out examples)_
```php
//=> routes/web.php

//note the Facade change
use Sourcefli\PermissionName\Facades\TeamPermission;

Route::get('permissions', function () {
    TeamPermission::billing()->edit();
    //returns 'billing.[team].edit' 
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
        'user', //can be 'settings' related to a model in your app...
        'smtp', //or any random 'settings' that your app uses..
    ]
];
```

### Now Use It
This example might be the permission used when you want to know if:

_The current user can edit the smtp settings that THEY OWN..._
```php
//=> routes/web.php

//note the Facade change
use Sourcefli\PermissionName\Facades\OwnedSettingPermission;

Route::get('permissions', function () {
    OwnedSettingPermission::smtp()->edit();
    //returns 'smtp.[owned_setting].edit' 
});

//or, get all 'settings' now available to you:
Route::get('permissions', function () {
    return collect([OwnedSettingPermission::all(), TeamSettingPermission::all()])->toArray();
});

```
This example might be the permission used when you want to know if:

_The current user can edit the smtp settings THEIR TEAM OWNS_
```php
//=> routes/web.php

//note the Facade change
use Sourcefli\PermissionName\Facades\TeamSettingPermission;

Route::get('permissions', function () {
    TeamSettingPermission::smtp()->edit();
    //returns 'smtp.[team_setting].edit' 
});
```

**Any distinction between the 'team' scope and the 'owned' scope is open to interpretation as is needed for your app, of course. I'm just listing out some examples of how I've used these permission strings before.**

---


### Global Helpers
Like Laravel's global helper function's, there are 4 global functions available.
They are:
```php
ownedPermission();
ownedSettingPermission();
teamPermission();
teamSettingPermission();
```

### Helper Function Arguments

**Option A.**

If you pass a resource or setting (whichever is relevant to the function you're calling)
as an argument, all of these functions will return their respective adapter - which means you can chain
any of the retrieval methods onto it just like the Facade behavior, like so:
```php
ownedPermission('billing')->read();
//returns 'billing.[owned].read'

//or 

teamSettingPermission('smtp')->restore();
//returns 'smtp.[team_setting].restore'

//the 'only' and 'except' methods (explained below) can be chained here as well...
ownedSettingPermission('smtp')->only('browse', 'add', 'delete');
//returns a Laravel Collection only containing these 3 permission strings

teamPermission('billing')->except('*', 'force_delete');
//returns a Laravel Collection with all permissions in the 'billing.[team]' prefix, 
//excluding '*' and 'force_delete'
```
**Option B:**

If no argument is passed to any of these methods, you will get a collection
of all the permissions that are related to that 'scope':
```php
teamSettingPermission();
//returns all 'settings' permissions within the [team_setting] scope

ownedPermission();
//return all 'resources' permissions within the [owned] scope

//etc..
 
```

---

### ONLY and EXCEPT methods
As briefly shown above, when you're defining roles and which permissions are associated with them, you'll need to tell your app which permissions should be included/excluded from each set of 'resources' or 'settings' that you've defined in the config file.
For this, you can use the `only()` method or the `except()` method. These methods accept a list of abilities as a comma-seperated string or an array.  

For Example, if using the same configs as mentioned above:
```php

OwnedPermission::billing()->only('browse', 'edit');
// returns a Collection that only includes:
// [
//     'billing.[owned].browse',
//     'billing.[owned].edit'
// ]

//or 

TeamPermission::user()->except(['edit','delete', 'force_delete', '*']);
// returns a Collection that only excludes these parameters:
// [
//     'user.[team].browse',
//     'user.[team].read',
//     'user.[team].add',
//     'user.[team].restore',
// ]

```
#### !! Important Note !!
Be careful when using the `except()` method since the `*` permission is always present in the 
Collection that gets returned, and will remain present unless otherwise specified. 

> Similar to parsing requests within Laravel, it's safest to stick with the `only()` method 
> to ensure you're cherry-picking the exact permissions you're looking for.

---

Since All Facades are aliased in the global namespace, using the Facades in your views wont create a mess either.
```php
//=> dashboard.blade.php (for example)

//If using Laravel Gate or something like 'Spatie Permission' 
@if (Auth::user()->can(TeamPermission::profile()->browse(), $team))
    User CAN browse the profile for their team
@else
    User CAN NOT view the profile for their team
@endif

/* 
* Global Helpers
* You can also use one of the four global helper functions
* that are available... 
*/

@if (Auth::user()->can(teamPermission('profile')->browse(), $team))
    User CAN browse the profile for their team
@else
    User CAN NOT view the profile for their team
@endif

//or
@if (Auth::user()->can(ownedSettingPermission('smtp')->edit(), $team))
    User CAN edit the their own smtp settings
@else
    User CAN NOT edit the their own smtp settings
@endif

//...etc.
```

```php

//You can use these methods on the 'settings' Facades as well...

OwnedSettingPermission::smtp()->only('browse', 'edit', 'delete');
// returns a Collection with:
// [
//     'smtp.[owned_setting].browse',
//     'smtp.[owned_setting].edit',
//     'smtp.[owned_setting].delete',
// ]


//or for 'team_settings'...

TeamSettingPermission::smtp()->except('browse', 'read', 'force_delete', '*');
// returns a Collection with:
// [
//     'smtp.[team_setting].add',
//     'smtp.[team_setting].edit',
//     'smtp.[team_setting].delete',
//     'smtp.[team_setting].restore',
// ]
```


### Retrieval 'all' Permissions
This example provides access to ALL permissions available ('resources' and 'settings' combined):
```php
//=> routes/web.php
use Sourcefli\PermissionName\Facades\AllPermissions;

Route::get('permissions', function () {
    AllPermissions::all();
    //returns a Laravel Collection of all available permissions that were generated
});
```
This example returns all 'resources' within the 'owned' scope: 

_(see below for further explanation on 'scope')_ 
```php
//=> routes/web.php
use Sourcefli\PermissionName\Facades\OwnedPermission;

Route::get('permissions', function () {
    OwnedPermission::all();
    //returns a Laravel Collection of all 'resource' permissions within the 'owned' scope
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

---

## A Little More In Depth

**'Permission Set' Definition:**

In the config, any 'resource' or 'setting' will get it's own _set of permissions_... 
For example:
```php
//=> config/permission-name-generator.php

//if your config looks like this...
return [
    "resources" => [
        "user",
        "billing"
    ],
    'settings' => [
        'smtp'
    ]
];
```

Adding those three items to your config would generate the following 'permission sets'
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
  "smtp.[owned_setting].browse",
  "smtp.[owned_setting].read",
  "smtp.[owned_setting].edit",
  "smtp.[owned_setting].add",
  "smtp.[owned_setting].delete",
  "smtp.[owned_setting].restore",
  "smtp.[owned_setting].force_delete",
  "smtp.[owned_setting].*",
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
  "smtp.[team_setting].browse",
  "smtp.[team_setting].read",
  "smtp.[team_setting].edit",
  "smtp.[team_setting].add",
  "smtp.[team_setting].delete",
  "smtp.[team_setting].restore",
  "smtp.[team_setting].force_delete",
  "smtp.[team_setting].*"
];
```
As you can see, each 'resource' listed in the config will generate one 'permission set' of `[owned]` permissions and one 'permission set' of `[team]` permissions.

And any 'setting' item listed in the config will generate one 'permission set' of `[owned_setting]` and one 'permission set' of `[team_setting]` 

Each 'permission set' contains all 8 permissions:
- browse
- read
- edit
- add
- delete
- restore
- force_delete
- `*`

**Calling On Permissions Throughout Your App:**

Using the same config as mentioned in the 'Permission Set' definition, 
you can call methods using the same name on each related Facade. 

**_With the exception of the `AllPermissions` facade, which I'll get to in a bit._

For Example, we can now call these methods:
```php
use OwnedPermission;
use TeamPermission;

/**
 * for 'resource' related items
 */ 

OwnedPermission::user()->delete();
//=> returns 'user.[owned].delete'

//..or 

TeamPermission::billing()->wildcard();
//=> returns 'billing.[team].*'


// or any of the 'retrieval methods' (explained below)
```

### Retrieval Methods:

'Retreival Methods' are the methods that you can chain onto any of 
your `resources` or `settings` methods that you've already called on a Facade.

These include:

`browse()`

`read()`

`edit()`

`add()`

`delete()`

`force_delete()`

`restore()`

`wildcard()`

For Example:

_for any of your 'resources', you can call_
    
    OwnedPermission::user()->create(); 

    TeamPermission::billing()->edit();

    ...

_or, for your 'settings'_

    OwnedSettingPermission::smtp()->read();

    TeamSettingPermission::smtp()->delete();

    ...

---

## The `AllPermissions` Facade
This facade works a little differently then the others, though it's just a small difference.
If want to get a collection of ALL your permissions, you can call:
```php
 AllPermission::all();
//This will give you a combined Laravel Collection of 'resources' and 'settings' that you've listed in your config file..
 ```

**Getting Individual Permissions From The `AllPermission` Facade:**

If you want to retrieve permission strings from this Facade, it's a little different from the others.

First, you have set a `scope`, then you can chain the standard methods as listed above (check out the tests [starting here](https://github.com/Sourcefli/laravel-permission-name-generator/tree/main/tests/Feature/AllPermissions) for sample usage).

There are 4 methods that set the scope for the `AllPermissions` Facade: 
```php
use AllPermissions;

AllPermissions::forOwned();
AllPermissions::forTeam();
AllPermissions::forOwnedSetting();
AllPermissions::forTeamSetting();

//Once you set the scope, continue chaining like any of the other Facades...

// e.g. for one of your 'resources' 
AllPermissions::forOwned()->billing()->delete();
//returns 'billing.[owned].delete'

// e.g. or one of your 'settings'
AllPermissions::forTeamSetting()->smtp()->edit();
//returns 'smtp.[team_setting].edit'

```

### The 'all' Method On All Facades:

You can call the `all()` method on any of the Facades in order to:
    
A. Get a complete list of permissions that are within that scope, if no resource is set.
_(see example 'A' below)_

B. Get a set resource/setting related permissions, if the resource/setting is set on that instance.
_(see example 'B' below)_

`owned`, `team`, `owned_setting`, `team_setting`

For Example:
```php

use Sourcefli\PermissionName\Facades\AllPermissions;
use Sourcefli\PermissionName\Facades\OwnedPermission;
use Sourcefli\PermissionName\Facades\TeamSettingPermission;


/**
 * A. 
 * We're in the 'owned' scope here... 
 */
OwnedPermission::all();
// returns all 'resource' permissions that include '[owned]'

/**
 * B. 
 * We're in the '[team_setting]' scope here... 
 */ 
TeamSettingPermission::billing()->all();
// returns all '[team_settings]' permissions related to billing

/**
 * C. 
 * Lastly...the one case were a 'scope' is not required:
 * To get a Collection that combines your 'resources' and 'settings'
 * and every permission your app has...
 */ 
AllPermissions::all();
```

### QA: 
>1. **What are the brackets for on each permission string?**
>
> This is to prevent any naming clashes with the 'resources' and 'settings' that you have listed in your config file.
> If you're looking at the source code, these are often referred to as `ownershipScopes` or just `scopes`


> 2. **Why Is Everything Singular?**
>
> This is intentional and provides a unified and predictable format across the board...
> The `AllPermissions` Facade is the only thing that's not singular.


> 3. **Can I add my own scopes?**
>
> No, right now there's only 4 available. Each represented by a Facade, or their own global helper
>   -   owned permissions
>   -   team permissions
>   -   owned setting permissions
>   -   team setting permissions

   
> 4. **Can Permissions be queried in any way?**
>
> Only if you've saved the permissions to your database, then you can use your ORM.
> This package is only intended to either return an \Illuminate\Support\Collection of 
> permissions (either scoped, or all permissions, using the `AllPermissions` Facade).
> or to retrieve a single permission as a string. 
> I plan to add the `only()` and `except()` methods (like [Spatie's Data Transfer Object Package](https://github.com/spatie/data-transfer-object))
> but that's as fancy as the methods will get. I intend to keep this package as simple as possible.

### Back To The Top
[Back To The Top](https://github.com/Sourcefli/laravel-permission-name-generator#quick-start)


### Credits

- [Spatie](https://spatie.be/)
    For doing all the hard work in their permissions package. I also make use of their [once](https://github.com/spatie/once)
    function to help with performance in this package.


### Security

- Please let me know of any security related issues asap at mail@jhavens.tech.

### License
**MIT**. 

Please see the [opensource.org](https://opensource.org/licenses/MIT) site definition for more information.

