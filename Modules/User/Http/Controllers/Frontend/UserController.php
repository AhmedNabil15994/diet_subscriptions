<?php

namespace Modules\User\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\Dashboard\UserRequest;
use Modules\User\Http\Requests\Frontend\UpdateProfileRequest;

class UserController extends Controller
{

    public function index()
    {
        return view('user::frontend.profile');
    }


    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user()->update($request->validated());
        return back()->with(['success' => __('profile update successfully')]);
    }
}
