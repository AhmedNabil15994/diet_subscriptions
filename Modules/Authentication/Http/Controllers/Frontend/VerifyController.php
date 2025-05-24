<?php

namespace Modules\Authentication\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Area\Entities\Country;
use PragmaRX\Countries\Package\Countries;
use Illuminate\Validation\ValidationException;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Frontend\RegisterRequest;
use Modules\Authentication\Repositories\Frontend\AuthenticationRepository as AuthenticationRepo;

class VerifyController extends Controller
{
    

    public function verify()
    {
        $user =  auth()->user();
        return view("user::frontend.verified", compact("user"));
    }
    public function verified(Request $request)
    {
        $request->validate([
            "code" => "required"
        ]);
        $user = auth()->user();
        if ($user->code_verified == $request->code) {
            $user->update(["code_verified" => null, "is_verified" => true]);
            return redirect()->route("frontend.user.my-profile")->withSuccess(__("user::frontend.verified.verified_success"));
        }
        throw ValidationException::withMessages(["code" => __('authentication::api.register.messages.code')]);
    }
}
