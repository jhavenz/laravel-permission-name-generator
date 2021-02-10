## Laravel Permission Name Generator

### Warning: This package is still a work in progress!!
> !! **PLEASE DO NOT** use this package in a production environment yet !!
>
> **Contributions And Feedback Are Welcome**
> I'm currently doing this in some of my own projects over the next few months as well.
>   
> - __Anyone who's good at generating doc blocks programatically would be **very welcome** to contribute a command that generates the doc blocks (on the Facades) for each 'Resource' and 'Setting' that user enters would be fantastic!__

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

**_There is ZERO logic when the time comes to AUTHORIZING ANYTHING throughout your app. This is an entirely seperate matter._**

**All package logic is related to generating 'permission strings' very easily and retrieving them very easily throughout your app. Convention and Predictability are at the heart of what this package provides.**

---
## Quick Start
I've been using Spatie's [Spatie Permissions](https://github.com/spatie/laravel-permission) package a lot lately and got pretty annoyed with always having to remember which permissions were plural, which syntax allowed the user to view 'team' permissions (though I had a 'Team' model, so it had to be something besides 'team' or 'teams'), vs which permissions were just for the user's own resources. On top of that, having to hard code permission strings throughout the application, or create a wrapper each time. 
It seemed like such a common routine, I decided to venture out and create a package, albeit my first public package. 
_So please go easy on me guys, if you find any issue. I'm willing and open to any **constructive** criticism_

### TLDR;
This package is an effort to create a convention to naming, generating, and accessing predictable and reliable permission strings. 

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
```
**or**

This example might be the permission used when you want to know if:

_The current user can edit the smtp settings for THEIR ENTIRE TEAM_
```php
//=> routes/web.php

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

_The current User can edit THEIR OWN smtp settings..._
```php
//=> routes/web.php

//note the Facade change
use Sourcefli\PermissionName\Facades\OwnedSettingPermission;

Route::get('permissions', function () {
    OwnedSettingPermission::smtp()->edit();
    //returns 'smtp.[owned_setting].edit' 
});
```
or

This example might be the permission used when you want to know if:

_The current User can edit THEIR TEAMS smtp settings (or any smtp settings owned by their THEIR TEAM)_
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

### ONLY and EXCEPT methods
Often times, when you're defining roles, and which permissions are associated with them, you'll need to tell your app which permissions should be included/excluded from each set of 'resources' or 'settings' that you've defined in the config file.
For this, you can use the `only()` method or the `except()` method. These methods accept a comma-seperated list of 'abilities' or an array.

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
Similar to parsing requests within Laravel, it's safest to stick with the `only()` method 
to ensure you're cherry-picking the exact permissions you're looking for.

---

Since All Facades are aliased to global namespace, using the Facades in your views wont create a mess.
```php
//=> dashboard.blade.php (for example)

//If using Laravel Gate or something like 'Spatie Permission' 
@if (Auth::user()->can(TeamPermission::profile()->browse(), $team))
    User CAN browse the profile for their team
@else
    User CAN NOT view the profile for their team
@endif

/**
 * Side Note:
 * I've thought about the idea of adding global helpers for retrieving the permission string in this situation
 * but not quite sure how it'd work yet.. 
 * 
 * maybe..
 * teamPermissionFor('profile.browse')
 * 
 * or, I personally like this one best so far. As few hard-coded strings as possible...
 * teamPermission('profile')->browse() 
 * 
 * still open for suggestions on this
 */ 
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
    //returns an Laravel Collection of all available permissions that were generated
});
```
This example returns all 'resources' within the 'owned' scope: 

_(see below for further explanation on 'scope')_ 
```php
//=> routes/web.php
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
Using the same config as mentioned in the 'Permission Set' definition, you can call methods using the same name on each related Facade. **_With the exception of the `AllPermissions` facade, which I'll get to in a bit._

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

*Retrieval Methods:*
'Retreival Methods' are the methods that you can chain onto any of your 'resource' or 'setting' methods on the Facades.
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

_for your 'resources'_
`OwnedPermission::user()->create()` 
`TeamPermission::billing()->edit()`

_or, for your 'settings'_
`OwnedSettingPermission::smtp()->read()`
`TeamSettingPermission::smtp()->delete()`

**Note:**

These 'retrieval' methods are all listed in [this contract](https://github.com/Sourcefli/laravel-permission-name-generator/blob/main/src/Contracts/RetrievesPermissions.php). You'll also see the 'all' method in this contract, please continue reading.

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
//for a 'resource' 
AllPermissions::forOwned()->billing()->delete();
//returns 'billing.[owned].delete'

//or for a 'setting'
AllPermissions::forTeamSetting()->smtp()->edit();
//returns 'smtp.[team_setting].edit'

```

### The 'all' Method On All Facades:

You can call the `all()` method on any of the Facades in order to get a complete list of permissions that are within that scope. Hopefully scopes are clear by now, the package comes with 4 different 'scopes'...
`owned`, `team`, `owned_setting`, `team_setting`

For Example:
```php

use Sourcefli\PermissionName\Facades\AllPermissions;
use Sourcefli\PermissionName\Facades\OwnedPermission;
use Sourcefli\PermissionName\Facades\TeamSettingPermission;


/**
 * We're in the 'owned' scope here... 
 */
OwnedPermission::all();
// returns all 'resource' permissions that include '[owned]'

/**
 * We're in the 'team_setting' scope here... 
 */ 
TeamSettingPermission::all();
// returns all 'settings' permissions that include '[team_setting]' 
 

/**
 * lastly...the one method were a 'scope' is not required
 * to get a Collection that combines your 'resources' and 'settings' in config...
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
> This is definitely intentional, since when I'm working on my own projects, I was always having to lookup what was singular and what wasn't.
> The `AllPermissions` Facade is the only thing that's singular (unless I overlooked something somewhere, if so please let me know).
> This provides a unified and predictable format across the board... 


> 3. **Can I add my own scopes?**
>
> No, right now there's only 4 available... as represented by the Facades.
   
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
    function to help with performance within this package.


### Security

- Please let me know of any security related issues asap at mail@jhavens.tech.

### License
**MIT**. 

Please see the [opensource.org](https://opensource.org/licenses/MIT) site definition for more information.


#### This package is still a work in progress!! Please dont use in any production environment yet!