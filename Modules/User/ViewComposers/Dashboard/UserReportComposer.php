<?php

namespace Modules\User\ViewComposers\Dashboard;

use Modules\User\Repositories\Dashboard\UserRepository as User;
use Illuminate\View\View;
use Cache;

class UserReportComposer
{
    public function __construct(User $user)
    {
        $this->userCreated =  $user->userCreatedStatistics();
        $this->countUsers  =  $user->countUsers();
    }

    public function compose(View $view)
    {
        $view->with('userCreated', $this->userCreated);
        $view->with('countUsers', $this->countUsers);
    }
}
