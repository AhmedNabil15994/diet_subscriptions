<?php

use Modules\Authorization\ViewComposers\Dashboard\AdminRolesComposer;

view()->composer([
  'user::dashboard.admins.index',
], AdminRolesComposer::class);
