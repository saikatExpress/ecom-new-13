<?php

return [

    'create_users' => false,

    'truncate_tables' => true,

    'modules' => [
        'dashboard' => [
            'dashboard' => 'r',
        ],

        'user_management' => [
            'user'          => 'c,r,u,d',
            'user_category' => 'c,r,u,d',
            'role'          => 'c,r,u,d',
            'permission'    => 'c,r,u,d',
        ],

        'product' => [
            'product'         => 'c,r,u,d',
            'category'        => 'c,r,u,d',
            'sub_category'    => 'c,r,u,d',
            'brand'           => 'c,r,u,d',
            'attribute'       => 'c,r,u,d',
            'attribute_value' => 'c,r,u,d',
        ],

        'order' => [
            'order_source'     => 'c,r,u,d',
            'customer_type'    => 'c,r,u,d',
            'payment_gateway'  => 'c,r,u,d',
            'delivery_gateway' => 'c,r,u,d',
            'cancel_reason'    => 'c,r,u,d',
            'order'            => 'c,r,u,d,assign,invoice,change-status,cancel,return',
        ],

        'cms' => [
            'page'    => 'c,r,u,d',
            'section' => 'c,r,u,d',
            'slider'  => 'c,r,u,d',
            'banner'  => 'c,r,u,d',
        ],

        'blog' => [
            'blog_category' => 'c,r,u,d',
            'tag'           => 'c,r,u,d',
            'blog'          => 'c,r,u,d',
        ],

        'report' => [
            'report' => 'r,export',
        ],

        'setting' => [
            'setting' => 'c,r,u,d',
        ],
    ],

    'roles' => [
        'superadmin' => [

            'dashboard' => [
                'dashboard' => 'r',
            ],

            'user_management' => [
                'user'          => 'c,r,u,d',
                'user_category' => 'c,r,u,d',
                'role'          => 'c,r,u,d',
                'permission'    => 'c,r,u,d',
            ],

            'product' => [
                'product'         => 'c,r,u,d',
                'category'        => 'c,r,u,d',
                'sub_category'    => 'c,r,u,d',
                'brand'           => 'c,r,u,d',
                'attribute'       => 'c,r,u,d',
                'attribute_value' => 'c,r,u,d',
            ],

            'order' => [
                'order_source'     => 'c,r,u,d',
                'customer_type'    => 'c,r,u,d',
                'payment_gateway'  => 'c,r,u,d',
                'delivery_gateway' => 'c,r,u,d',
                'cancel_reason'    => 'c,r,u,d',
                'order'            => 'c,r,u,d,assign,invoice,change-status,cancel,return',
            ],

            'cms' => [
                'page'    => 'c,r,u,d',
                'section' => 'c,r,u,d',
                'slider'  => 'c,r,u,d',
                'banner'  => 'c,r,u,d',
            ],

            'blog' => [
                'blog_category' => 'c,r,u,d',
                'tag'           => 'c,r,u,d',
                'blog'          => 'c,r,u,d',
            ],

            'report' => [
                'report' => 'r,export',
            ],

            'setting' => [
                'setting' => 'c,r,u,d',
            ],
        ],

        'admin' => [

            'dashboard' => [
                'dashboard' => 'r',
            ],

            'user_management' => [
                'user'          => 'c,r,u,d',
                'user_category' => 'c,r,u,d',
                'role'          => 'c,r,u,d',
                'permission'    => 'c,r,u,d',
            ],

            'product' => [
                'product'         => 'c,r,u,d',
                'category'        => 'c,r,u,d',
                'sub_category'    => 'c,r,u,d',
                'brand'           => 'c,r,u,d',
                'attribute'       => 'c,r,u,d',
                'attribute_value' => 'c,r,u,d',
            ],

            'order' => [
                'order_source'     => 'c,r,u,d',
                'customer_type'    => 'c,r,u,d',
                'payment_gateway'  => 'c,r,u,d',
                'delivery_gateway' => 'c,r,u,d',
                'cancel_reason'    => 'c,r,u,d',
                'order'            => 'c,r,u,d,assign,invoice,change-status,cancel,return',
            ],

            'cms' => [
                'page'    => 'r,u',
                'section' => 'r,u',
                'slider'  => 'r,u',
                'banner'  => 'r,u',
            ],

            'blog' => [
                'blog_category' => 'r',
                'tag'           => 'r',
                'blog'          => 'r',
            ],

            'report' => [
                'report' => 'r,export',
            ],

            'setting' => [
                'setting' => 'r,u',
            ],
        ],

        'teamlead' => [

            'dashboard' => [
                'dashboard' => 'r',
            ],

            'user_management' => [
                'user'          => 'c,r,u,d',
                'user_category' => 'c,r,u,d',
                'role'          => 'c,r,u,d',
                'permission'    => 'c,r,u,d',
            ],

            'product' => [
                'product'      => 'c,r,u,d',
                'category'     => 'c,r,u,d',
                'sub_category' => 'c,r,u,d',
                'brand'        => 'c,r,u,d',
            ],

            'order' => [
                'order_source' => 'r',
                'order'        => 'r,u,assign',
            ],

            'cms' => [
                'page'    => 'r,u',
                'section' => 'r,u',
                'slider'  => 'r,u',
                'banner'  => 'r,u',
            ],

            'blog' => [
                'blog_category' => 'r',
                'tag'           => 'r',
                'blog'          => 'r',
            ],

            'report' => [
                'report' => 'r',
            ],
        ],

        'staff' => [
            'dashboard' => [
                'dashboard' => 'r',
            ],

            'product' => [
                'product' => 'r',
            ],

            'order' => [
                'order' => 'r,u',
            ],
        ],
    ],

    'permissions_map' => [
        'c' => 'create',

        'r' => 'read',

        'u' => 'update',

        'd' => 'delete',
    ],
];
