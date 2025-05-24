<?php

// Dashboard ViewComposr
view()->composer([
    'category::dashboard.categories.*',
    'company::dashboard.companies.*',
    'coupon::dashboard.*',
], \Modules\Category\ViewComposers\Dashboard\CategoryComposer::class);



//Frontend ViewComposer

view()->composer([
    'apps::frontend.*',
    'package::frontend.*',
], \Modules\Category\ViewComposers\Frontend\CategoryComposer::class);
