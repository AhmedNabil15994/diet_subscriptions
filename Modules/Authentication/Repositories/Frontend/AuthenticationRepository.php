<?php

namespace Modules\Authentication\Repositories\Frontend;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Packages\SMS\SmsBox;
use Modules\User\Entities\PasswordReset;

class AuthenticationRepository
{
    public function __construct(User $user, PasswordReset $password)
    {
        $this->password = $password;
        $this->user = $user;
    }

    public function register($request)
    {

        DB::beginTransaction();

        try {
            $data = $request;
            $data['code_verified'] = rand(1000, 9000);
            $user = $this->user->create($data);
            $this->sendCode($data['code_verified'], $user->mobile);
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function findUserByEmail($request)
    {
        $user = $this->user->where('email', $request->email)->first();
        return $user;
    }

    public function createToken($request)
    {
        $user = $this->findUserByEmail($request);

        $this->deleteTokens($user);

        $newToken = strtolower(Str::random(64));

        $token = $this->password->insert([
            'email' => $user->email,
            'token' => $newToken,
            'created_at' => Carbon::now(),
        ]);

        $data = [
            'token' => $newToken,
            'user' => $user
        ];

        return $data;
    }

    public function resetPassword($request)
    {
        $user = $this->findUserByEmail($request);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        $this->deleteTokens($user);

        return true;
    }

    public function deleteTokens($user)
    {
        $this->password->where('email', $user->email)->delete();
    }

    public function sendVerificationCode($mobile)
    {
        $user = User::whereMobile($mobile)->first();
        $data['code_verified'] = rand(1000, 9000);
        $user->update($data);
        $this->sendCode($data['code_verified'], $mobile);
    }

    public function sendCode($code, $mobile)
    {
        if (app()->environment('production', 'staging')) {
            try {
                app(SmsBox::class)->send($code, $mobile);
            } catch (Exception $e) {
                info($e->getMessage());
            }
        }
    }
}
