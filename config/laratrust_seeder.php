<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Create Default Users
    |--------------------------------------------------------------------------
    */

    'create_users' => false,

    /*
    |--------------------------------------------------------------------------
    | Truncate Tables Before Seeding
    |--------------------------------------------------------------------------
    */

    'truncate_tables' => true,

    /*
    |--------------------------------------------------------------------------
    | Available Modules & Permissions
    |--------------------------------------------------------------------------
    |
    | এখানে project-এর সব module থাকবে।
    | নতুন module add করতে শুধু এখানেই add করলেই হবে।
    |
    */

    'modules' => [
        'dashboard'       => 'r',
        'product'         => 'c,r,u,d',
        'category'        => 'c,r,u,d',
        'sub_category'    => 'c,r,u,d',
        'brand'           => 'c,r,u,d',
        'attribute'       => 'c,r,u,d',
        'attribute_value' => 'c,r,u,d',
        'order'           => 'c,r,u,d,assign,invoice,change-status,cancel,return',
        'cms'             => 'c,r,u,d',
        'section'         => 'c,r,u,d',
        'slider'          => 'c,r,u,d',
        'banner'          => 'c,r,u,d',
        'blog_category'   => 'c,r,u,d',
        'tag'             => 'c,r,u,d',
        'blog'            => 'c,r,u,d',
        'report'          => 'r,export',
        'setting'         => 'c,r,u,d',
    ],

    /*
    |--------------------------------------------------------------------------
    | Roles & Permissions
    |--------------------------------------------------------------------------
    |
    | কোন Role কোন Module-এর কোন Permission পাবে।
    |
    */

    'roles' => [

        'superadmin' => [
            'dashboard'       => 'r',
            'product'         => 'c,r,u,d',
            'category'        => 'c,r,u,d',
            'sub_category'    => 'c,r,u,d',
            'brand'           => 'c,r,u,d',
            'attribute'       => 'c,r,u,d',
            'attribute_value' => 'c,r,u,d',
            'order'           => 'c,r,u,d,assign,invoice,change-status,cancel,return',
            'cms'             => 'c,r,u,d',
            'section'         => 'c,r,u,d',
            'slider'          => 'c,r,u,d',
            'banner'          => 'c,r,u,d',
            'blog_category'   => 'c,r,u,d',
            'tag'             => 'c,r,u,d',
            'blog'            => 'c,r,u,d',
            'report'          => 'r,export',
            'setting'         => 'c,r,u,d',
        ],

        'admin' => [
            'dashboard'       => 'r',
            'product'         => 'c,r,u,d',
            'category'        => 'c,r,u,d',
            'sub_category'    => 'c,r,u,d',
            'brand'           => 'c,r,u,d',
            'attribute'       => 'c,r,u,d',
            'attribute_value' => 'c,r,u,d',
            'order'           => 'c,r,u,d,assign,invoice',
            'cms'             => 'r,u',
            'section'         => 'r,u',
            'slider'          => 'r,u',
            'banner'          => 'r,u',
            'blog_category'   => 'r',
            'tag'             => 'r',
            'blog'            => 'r',
            'report'          => 'r,export',
        ],

        'teamlead' => [
            'dashboard' => 'r',
            'product'   => 'c,r,u,d',
            'category'  => 'c,r,u,d',
            'brand'     => 'c,r,u,d',
            'order'     => 'r,u,assign',
            'cms'       => 'r,u',
            'section'   => 'r,u',
            'slider'    => 'r,u',
            'banner'    => 'r,u',
            'tag'       => 'r',
            'blog'      => 'r',
            'report'    => 'r',
        ],

        'staff' => [
            'dashboard' => 'r',
            'product'   => 'r',
            'order'     => 'r,u',
        ],

    ],

    'permissions_map' => [

        'c' => 'create',

        'r' => 'read',

        'u' => 'update',

        'd' => 'delete',

    ],

];
