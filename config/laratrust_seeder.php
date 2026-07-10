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

        'dashboard'        => 'r',

        'product'          => 'c,r,u,d',

        'category'         => 'c,r,u,d',

        'sub_category'     => 'c,r,u,d',

        'sub_sub_category' => 'c,r,u,d',

        'brand'            => 'c,r,u,d',

        'order'            => 'c,r,u,d,assign,invoice,change-status,cancel,return',

        'customer'         => 'c,r,u,d',

        'employee'         => 'c,r,u,d,salary,commission,attendance',

        'report'           => 'r,export',

        'setting'          => 'c,r,u,d',

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

            'dashboard'        => 'r',

            'product'          => 'c,r,u,d',

            'category'         => 'c,r,u,d',

            'sub_category'     => 'c,r,u,d',

            'sub_sub_category' => 'c,r,u,d',

            'brand'            => 'c,r,u,d',

            'order'            => 'c,r,u,d,assign,invoice,change-status,cancel,return',

            'customer'         => 'c,r,u,d',

            'employee'         => 'c,r,u,d,salary,commission,attendance',

            'report'           => 'r,export',

            'setting'          => 'c,r,u,d',

        ],

        'admin' => [

            'dashboard' => 'r',

            'product'   => 'c,r,u,d',

            'category'  => 'c,r,u,d',

            'brand'     => 'c,r,u,d',

            'order'     => 'c,r,u,d,assign,invoice',

            'customer'  => 'r,u',

            'employee'  => 'r',

            'report'    => 'r,export',

        ],

        'teamlead' => [

            'dashboard' => 'r',

            'product'   => 'c,r,u,d',

            'category'  => 'c,r,u,d',

            'brand'     => 'c,r,u,d',

            'order'     => 'r,u,assign',

            'customer'  => 'r,u',

            'employee'  => 'r',

            'report'    => 'r',

        ],

        'staff' => [

            'dashboard' => 'r',

            'product'   => 'r',

            'order'     => 'r,u',

            'customer'  => 'r',

        ],

    ],

    'permissions_map' => [

        'c' => 'create',

        'r' => 'read',

        'u' => 'update',

        'd' => 'delete',

    ],

];
