<?php

namespace Modules\Authentication\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Area\Entities\Country;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Frontend\RegisterRequest;
use Modules\Authentication\Repositories\Frontend\AuthenticationRepository as AuthenticationRepo;
use PragmaRX\Countries\Package\Countries;

class RegisterController extends Controller
{
    use Authentication;

    public function __construct(AuthenticationRepo $auth)
    {
        $this->auth = $auth;
    }

    public function show(Request $request)
    {
        return view('authentication::frontend.register', compact('request'));
    }

    public function register(RegisterRequest $request)
    {
        if ($request->try_verified !== 'try_verified') {
            $registered = $this->auth->register($request->validated());
            if ($registered) {
                return response()->json([
                    true,
                    'A OTP is sent on your registered Email id or Mobile no .Please enter the OTP below:',
                    'try_verified' => 'try_verified',
                ]);
            }
        } else {
            $errors =  $this->loginFromOtp($request);
            if ($errors) {
                return response()->json([
                    false,
                    'try  to register again',
                    'url' => route('frontend.auth.register')

                ]);
            }

            return response()->json([
                true,
                'url' => route('frontend.home')
            ]);
        }
    }

    public function redirectTo($request)
    {
        if ($request['redirect_to'] == 'address') {
            return redirect()->route('frontend.order.address.index');
        }
        return redirect()->route('frontend.home');
    }
}
