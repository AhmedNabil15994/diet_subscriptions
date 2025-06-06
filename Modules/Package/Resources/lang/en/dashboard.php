<?php

return [
    'packages' => [
        'routes'    => [
            'index'     => 'Packages',
            "create"    => "Create package",
            "update"    => "Edit package"
        ],
        'datatable' => [
            'title' => 'Title',
            'description' => 'Description',
            'duration' => 'Duration',
            'is_free' => 'Is Free',
            "price"   => "Price",
            "status"  => "Status",
            "sort"    => "Order",

            'created_at' => 'Created At',
            'options' => 'Options',
        ],
        'form'      => [
            'title' => 'Title',
            'description' => 'Description',
            'is_free' => 'Is Free',
            'duration'    => 'meals count',

            "price"   => "Price",
            "status"  => "Status",
            'image' => 'image',

            "categories" => "Categories",
            "sort"    => "Order",
            'tabs'      => [
                'general'   => 'General Info.',
                'prices'   => 'Package Prices',
            ],
        ],

    ],
    'subscriptions' => [
        'statistics' =>
        [
            'all_active_ones_including_the_paused_ones' => 'كل النشط متضمن المتوقف مؤقتا',
        ],
        'routes'    => [
            'index'     => 'subscriptions',
            "create"    => "Create subscription",
            "update"    => "Edit subscriptions"
        ],
        'datatable' => [
            'title'        => 'Title',
            'description'  => 'Description',
            'duration'     => 'Duration',
            'user'         => 'user',
            'package'      => 'package',
            'address'      => 'address',
            'mobile'      => 'Mobile',
            'from_admin'   => 'from admin',
            'is_free'      => 'Is Free',
            'is_default'   => 'default package',
            'can_order_in' => 'can order in',

            "price"   => "Price",
            "start_at"   => "start_at",
            "end_at"   => "end_at",
            "status"  => "Status",
            "sort"    => "Order",
            'created_at' => 'Created At',
            'options' => 'Options',
            'note' => 'Note',
            'coupon' => 'Coupon',
            'no_coupon' => 'No Coupon',
            'pause' => 'Pause',
            'pause_active' => 'Paused now',
            'pause_stoped' => 'Not Paused',
            'pause_permanent'   => 'Permanent Paused',
            'permanent_pause_days'  => 'Permanent Pause Days',
            'permanent_pause'   => 'Permanent Suspension',
        ],
        'form'      => [
            'title' => 'Title',
            'description' => 'Description',
            'duration'    => 'meals count',
            'is_free'     => 'Is Free',
            "price"       => "Price",
            "status"      => "Status",
            'image'       => 'image',

            "categories" => "Categories",
            "sort"    => "Order",
            'tabs'      => [
                'general'   => 'General Info.',
            ],
        ],

    ],
    'suspensions' => [
        'messages' =>
        [
            'pause_p1' => 'The pause days range is greater than available maximum pause days for this subscription',
            'pause_p3' => 'The pause days range isn\'t in the subscription start & end dates range',
        ],
        'routes'    => [
            'index'     => 'suspensions',
            "create"    => "Create suspensions",
            "update"    => "Edit suspensions"
        ],
        'datatable' => [
            'title' => 'Title',
            'description' => 'Description',
            'duration'   => 'Duration',
            'user'       => 'user',
            'package' => 'package',
            'from_admin' => 'from admin',
            'is_free' => 'Is Free',
            "price"   => "Price",
            "start_at"   => "start at",
            "end_at"   => "end at",
            "status"  => "Status",
            "sort"    => "Order",

            'created_at' => 'Created At',
            'options' => 'Options',
        ],
        'form'      => [
            'title' => 'Title',
            'description' => 'Description',
            'duration' => 'Duration',
            'is_free' => 'Is Free',
            "price"   => "Price",
            'user' => 'user',
            "notes"   => "notes",
            "start_at"   => "start at",
            "end_at"   => "end at",
            "status"  => "Status",
            'image' => 'image',

            "categories" => "Categories",
            "sort"    => "Order",
            'tabs'      => [
                'general'   => 'General Info.',
            ],
        ],

    ],

    'print-settings'      => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'image'         => 'Image',
            'options'       => 'Options',
            'status'        => 'Status',
            'preview'         => 'preview',
            'name'         => 'Name',
            "description"         => "Description",
           "paper_width"        => "Paper Width"
        ],
        'form'      => [
            'status'        => 'Status',
            'name'         => 'Name',
            "description"         => "Description",
           "paper_width"        => "Paper Width",
           "is_continuous" => "Is continuous" ,
           "top_margin"    => "Top margin",
           "left_margin"   =>"Left Margin",
           "paper_width"=> "Paper width",
           "width"         =>"Width",
           "height"         =>"Height",
           "paper_width"   =>"Paper width",
           "paper_height"  =>"Paper height",
           "stickers_in_one_row"=>"Stickers in one row",
           "row_distance"=>"Row distance",
           "col_distance"  => "Col distance",
           "stickers_in_one_sheet"=>"Stickers in one sheet ",
            'tabs'              => [
                'general'       => 'General Info.',
                "input_lang"    =>"Data :lang"
            ],

        ],
        'routes'    => [

            'create'=> 'Create Print Setting',
            'index' => 'Print Setting',
            'update'=> 'Update Print Setting',
        ],

    ],
    'print' => [
        'datatable' => [
            "show_in" => "Information to show in Labels " ,
            "preview" =>"Preview"
        ],
        'form' => [

        ],
        'routes' => [
            'index' => 'Print',
        ],
        'validation' => [

        ],
    ],
];
