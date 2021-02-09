<?php

return [

    /**
     * Please see repo for extensive instructions:
     * @link https://github.com/Sourcefli/laravel-permission-name-generator
     *
     * Note:
     *  No migrations or database related logic is included in this package, nor is there any authorization logic.
     *  This package only generates strings and allows you to reference them as methods throughout your app.
     *  Persistence and authorization logic is entirely up to you
     */

     /*
     *  -- Required --
     *  the resources you'd like to have permissions for
     */
    "resources" => [
        "user",
        "billing",
    ],

    /*
     *  -- Optional --
     *  the settings you'd like to have permissions for.
     *  ...'smtp' is just an example, you can leave this array empty
     */
    "settings" => [
        'smtp',
    ]
];
