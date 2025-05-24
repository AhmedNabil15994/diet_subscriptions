<?php

// Dashboard ViewComposr
view()->composer([
    'company::dashboard.companies.*',
    'coupon::dashboard.*',
], \Modules\User\ViewComposers\Dashboard\UserComposer::class);
view()->composer([
    'apps::dashboard.index',
], \Modules\User\ViewComposers\Dashboard\UserReportComposer::class);
