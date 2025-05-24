<?php

return [
    'packages' => [
        'routes'    => [
            'index'     => 'الباقات',
            "create"    => " انشاء باقة",
            "update"    => "تعديل باقه"
        ],
        'datatable' => [
            'title' => 'العنوان',
            'description' => 'الوصف',
            'duration' => 'المده',
            'is_free' => 'مجانيه',
            "price"   => "السعر",
            "status"  => "الحاله",
            "sort"    => "الترتيب",
            'created_at' => 'تاريخ إتخاذ الإجراء',
            'options' => 'الخيارات',
        ],
        'form'      => [
            'title' => 'العنوان',
            'description' => 'الوصف',
            'image' => 'الصوره',
            'duration' => 'عدد الوجبات',
            'is_free' => 'مجانيه',
            "price"   => "السعر",
            "categories"   => "الاقسام",
            "status"  => "الحاله",
            "sort"    => "الترتيب",
            'tabs'      => [
                'general'   => 'بيانات عامة',
                'prices'   => 'أسعار الباقة',
            ],
        ],

    ],
    'subscriptions' => [
        'statistics' =>
        [
            'all_active_ones_including_the_paused_ones' => 'كل النشط متضمن المتوقف مؤقتا',
            'active' => 'نشط',
        ],
        'routes'    => [
            'index'     => 'الاشتراكات',
            "create"    => " انشاء اشتراك",
            "update"    => "تعديل اشتراك"
        ],
        'datatable' => [
            'user' => 'المستخدم',
            'package' => 'الباقه',
            'from_admin' => 'من خلال الادمن',
            'is_free' => 'مجانيه',
            'is_default' => 'باقه افتراضيه',
            'can_order_in' => 'يستطيع الطلب يوم',
            "price"   => "السعر",
            'mobile'      => 'رقم الهاتف',
            "status"  => "الحاله",
            "start_at"   => "تاريخ البدايه",
            "end_at"   => "  تاريخ النهايه",
            "sort"    => "الترتيب",
            'created_at' => 'تاريخ إتخاذ الإجراء',
            'options' => 'الخيارات',
            'note' => 'ملاحظة',
            'address' => 'العنوان',
            'coupon' => 'الكوبون',
            'no_coupon' => 'لا يوجد',
            'pause' => 'الإيقاف',
            'pause_active' => 'متوقفه حاليا',
            'pause_stoped' => 'غير متوقفة',
            'pause_permanent'   => 'متوقفه نهائيا',
            'permanent_pause'   => 'ايقاف نهائيا',
            'permanent_pause_days'  => 'أيام الاشتراك قبل التوقف الدائم',
        ],
        'form'      => [
            'title' => 'العنوان',
            'description' => 'الوصف',
            'image' => 'الصوره',
            'duration' => 'المده',
            'is_free' => 'مجانيه',
            "price"   => "السعر",
            "categories"   => "الاقسام",
            "status"  => "الحاله",
            "sort"    => "الترتيب",
            'tabs'      => [
                'general'   => 'بيانات عامة',
            ],
        ],

    ],
    'suspensions' => [
        'messages' =>
        [
            'pause_p1' => 'يجب أن يكون عدد أيام الايقاف ضمن نطاق عدد الايام المتبقي في الاشتراك',
            'pause_p3' => 'يجب أن تكون أيام الايقاف ضمن نطاق فترة الاشتراك',
        ],
        'routes'    => [
            'index'     => 'الايقافات',
            "create"    => " انشاء الايقافات",
            "update"    => "تعديل الايقافات"
        ],
        'datatable' => [
            'user' => 'المستخدم',
            'package' => 'الباقه',
            'from_admin' => 'من خلال الادمن',
            'is_free' => 'مجانيه',
            "price"   => "السعر",
            "status"  => "الحاله",
            "start_at"   => "تاريخ البداية",
            "end_at"   => "تاريخ النهاية",
            "sort"    => "الترتيب",
            'created_at' => 'تاريخ إتخاذ الإجراء',
            'options' => 'الخيارات',
        ],
        'form'      => [
            'title' => 'العنوان',
            'description' => 'الوصف',
            'image' => 'الصوره',
            'duration' => 'المده',
            'is_free' => 'مجانيه',
            'user' => 'المستخدم',
            "start_at"   => "تاريخ البدايه",
            "notes"   => "ملاجظات ",
            "end_at"   => "  تاريخ النهايه",
            "price"   => "السعر",
            "categories"   => "الاقسام",
            "status"  => "الحاله",
            "sort"    => "الترتيب",
            'tabs'      => [
                'general'   => 'بيانات عامة',
            ],
        ],

    ],
    'print-settings'      => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'name'         => 'الاسم',
            'preview'         => 'عرض',
            "description"         => "الوصف",
            "method_transaction"=>"طريقة الدفع",
             "paper_width"=> "عرض الورقه"
        ],
        'form'      => [
            'status'        => 'الحالة',
            'name'         => 'الاسم',
            "description"         => "الوصف",
            "is_continuous" => "مستمر" ,
            "top_margin"    => "المارحن العلوى",
            "left_margin"   =>"المارجن الشمالى",
            "paper_width"=> "عرض الورقه",
            "width"         =>"العرض",
            "height"         =>"الطول",
            "paper_width"   =>"عرض الصفحة",
            "paper_height"  =>"طول الصفحه",
            "stickers_in_one_row"=>"عدد Stickers فى الصف الواحد",
            "row_distance"=>"المسافه بين الصفوف",
            "col_distance"  => "المسافه بين الاعمده",
            "stickers_in_one_sheet"=>"Stickers in one sheet ",
            'tabs'              => [
                'general'       => 'بيانات عامة',
                "input_lang"    =>"بيانات :lang"
            ],

        ],
        'routes'    => [

            'create'=> 'اضافة اعداد الطباعة ',
            'index' => ' اعدادت الطباعة',
            'update'=> 'تعديل اعدادت الطباعة',
        ],

    ],

    'print' => [
        'datatable' => [
            "show_in" => " المعلومات التى تظهر فى الطباعة" ,
            "preview" =>"عرض"
        ],
        'form' => [

        ],
        'routes' => [
            'index' => 'الطباعة ',
        ],
        'validation' => [

        ],
    ],
];
