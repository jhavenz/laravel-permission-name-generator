<?php

namespace Sourcefli\PermissionName;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Sourcefli\PermissionName\Exceptions\PermissionLookupException;
use Sourcefli\PermissionName\Factories\OwnedPermissions;

class PermissionName
{
    //V2
    protected Collection $ownedPermissions;

    //Previous
    protected array $resources;
    protected array $settings;

    protected Collection $allAbilities;
    protected Collection $abilities;
    protected string $category;
    protected string $type;

    /**
     * TODO -
        => Aliases to composer.json
            "OwnedSettingPermission": "Sourcefli\\PermissionName\\Facades\\OwnedSettingPermission",
            "TeamPermission": "Sourcefli\\PermissionName\\Facades\\TeamPermission",
            "SettingPermission": "Sourcefli\\PermissionName\\Facades\\SettingPermission"
        => Factories
            "TeamPermission"
            "OwnedSettingPermission"
            "TeamSettingPermission"
     */

    public function __construct()
    {
        $this->ownedPermissions = (new OwnedPermissions)->collectPermissions();


//        $this->settings = config('permission-name.settings');
//
//        $this->type = $type;
//
//        $this->allAbilities = $this->filterAllRelatedPermissions();
//
//        $this->abilities = collect();
    }

    public function all(): Collection
    {
        return $this->allAbilities;
    }

    public function current_user(): PermissionLookupManager
    {
        //Only one item for 'team' ... 'current_user.team.*' (super admin)
        $this->setCategory('current_user');

        return $this;
    }

    public function user(): PermissionLookupManager
    {
        $this->setCategory('user');

        return $this;
    }

    public function assignment(): PermissionLookupManager
    {
        $this->setCategory('assignment');

        return $this;
    }

    public function setting(string $settingCategory): PermissionLookupManager
    {
        $this->setCategory("setting.{$this->type}.{$settingCategory}");

        return $this;
    }

    public function billing(): PermissionLookupManager
    {
        $this->setCategory('billing'); //
        return $this;
    }

    public function notification(): PermissionLookupManager
    {
        $this->setCategory('notification'); //
        return $this;
    }

    public function permission(): PermissionLookupManager
    {
        $this->setCategory('permission'); //
        return $this;
    }

    public function guest_member(): PermissionLookupManager
    {
        $this->setCategory('guest'); //
        return $this;
    }

    public function client_member(): PermissionLookupManager
    {
        $this->setCategory('client'); //
        return $this;
    }

    public function support_member(): PermissionLookupManager
    {
        $this->category = '';
        $this->setCategory('support_member'); //
        return $this;
    }

    public function field_member(): PermissionLookupManager
    {
        $this->setCategory('field_member'); //
        return $this;
    }

    public function supervisor_member(): PermissionLookupManager
    {
        $this->setCategory('supervisor'); //
        return $this;
    }

    public function manager_member(): PermissionLookupManager
    {
        $this->setCategory('manager'); //
        return $this;
    }

    public function owner_member(): PermissionLookupManager
    {
        $this->setCategory('owner'); //
        return $this;
    }

    protected function setCategory(string $category)
    {
        if (Str::startsWith($category, 'setting.')) {
            $this->isValidSetting($category);
        } else {
            $this->isValidResource($category);
        }

        $this->category = $category;

        return $this;
    }

    public function browse()
    {
        $this->validCategoryIsSet();
        $this->reset();
        $this->filterForCategory();
        return $this->abilities->first(fn ($p) => Str::contains($p, 'browse'));
    }

    public function read()
    {
        $this->validCategoryIsSet();
        $this->reset();
        $this->filterForCategory();
        return $this->abilities->first(fn ($p) => Str::contains($p, 'read'));
    }

    public function edit()
    {
        $this->validCategoryIsSet();
        $this->reset();
        $this->filterForCategory();
        return $this->abilities->first(fn ($p) => Str::contains($p, 'edit'));
    }

    public function add()
    {
        $this->validCategoryIsSet();
        $this->reset();
        $this->filterForCategory();
        return $this->abilities->first(fn ($p) => Str::contains($p, 'add'));
    }

    public function delete()
    {
        $this->validCategoryIsSet();
        $this->reset();
        $this->filterForCategory();
        return $this->abilities->first(fn ($p) => Str::contains($p, 'delete'));
    }

    public function wildcard()
    {
        $this->validCategoryIsSet();
        $this->reset();
        $this->filterForCategory();
        return $this->abilities->first(fn ($p) => Str::endsWith($p, '.*'));
    }

    protected function validCategoryIsSet()
    {
        if (!isset($this->category)) {
            throw new PermissionLookupException("A Category must be set before retrieving a specific ability");
        }
    }

    protected function filterForCategory()
    {
        $this->abilities = $this
            ->allAbilities
            ->filter(
                fn ($p) =>
                Str::startsWith($p, $this->category)
            );


        return $this;
    }

    protected function reset()
    {
        $this->abilities = collect();

        return $this;
    }


    protected function filterAllRelatedPermissions()
    {
        if ($this->type === 'team') {
            return app('allPermissions')
                ->filter(
                    fn ($p) =>
                    !Str::startsWith($p, 'team') &&
                        Str::contains($p, '.team.')
                );
        }

        if ($this->type === 'owned') {
            return app('allPermissions')
                ->filter(
                    fn ($p) =>
                    !Str::startsWith($p, 'owned') &&
                        Str::contains($p, '.owned.')
                );
        }

        $msg = sprintf(
            "Ability type of %s is not valid. It should either be team or owned to lookup whether the user has permission to their own resources or the resources owned by the whole team",
            $this->type
        );

        throw new PermissionLookupException($msg);
    }

    private function isValidSetting(string $category)
    {
        if (!count($this->settings)) {
            throw new PermissionLookupException(
                "No setting-related permissions were specified within the `permission-name.settings` configuration"
            );
        }

        $category = Str::afterLast($category, '.');

        if (!in_array($category, $this->settings, true)) {

            throw new PermissionLookupException(
                "Settings permission of {$category} is not a valid settings category. All settings-related permissions should be listed in the `permission-name.settings` configuration."
            );
        }
    }

    private function isValidResource(string $resource)
    {
        if (!count($this->resources)) {
            throw new PermissionLookupException(
                "No resources were specified within the `permission-name.resources` configuration"
            );
        }

        if (!in_array($resource, $this->resources, true)) {
            throw new PermissionLookupException(
                "Resource of {$resource} is not valid. All resources should be listed within the `permission-name.resources` configuration."
            );
        }
    }

    // public function __callStatic($name, $arguments)
    // {
    //     $this->isValidResource($name);
    // }
}
