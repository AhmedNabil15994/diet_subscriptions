<?php

namespace Modules\Authentication\Http\Controllers\Frontend;

use Exception;
use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Modules\Core\Packages\SMS\SmsBox;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Frontend\LoginRequest;
use Modules\Authentication\Repositories\Frontend\AuthenticationRepository as AuthenticationRepo;

class LoginController extends Controller
{
    use Authentication;
    public function __construct(public AuthenticationRepo $auth)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function showLogin()
    {

        return view('authentication::frontend.login');
    }

    /**
     * Login method
     */
    public function postLogin(LoginRequest $request)
    {
        if (!User::where('mobile',$request->mobile)->exists()) {
            User::onlyTrashed()->where('mobile',$request->mobile)->forceDelete();
            User::create(['mobile' => $request->mobile, 'code_verified' => rand(1000, 9999)]);
            $this->auth->sendVerificationCode($request->mobile);
            return response()->json([
                true,
                'new_user' => 'new_user'
            ]);
        }

        if ($request->code_verified == null) {
            $this->auth->sendVerificationCode($request->mobile);
            return response()->json([
                true,
                'message' => 'A OTP is sent on your registered Email id or Mobile no .Please enter the OTP below:'
            ]);
        }

        $errors =  $this->loginFromOtp($request);
        if ($errors) {
            return response()->json([
                false,
                'message' => 'not valid credentials'
            ]);
        }
        if (auth()->user()->can('dashboard_access')) {
            return redirect('/dashboard');
        }

        $url = session()->has('last_url') ? session('last_url') : route('frontend.home');
        session()->forget('last_url');

        return response()->json([
            true,
            'url' => $url
        ]);
    }


    /**
     * Logout method
     */
    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('frontend.home');
    }
}
