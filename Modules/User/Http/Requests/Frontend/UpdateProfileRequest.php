<?php

namespace Modules\User\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'            => 'required',
            "phone_code"      => "sometimes|nullable",
            'mobile'          => 'required|phone:AUTO|unique:users,mobile,' . auth()->id() . '',
            'email'           => 'nullable|unique:users,email,' . auth()->id() . '',
            'password'        => 'nullable|confirmed|min:6',
        ];
    }
}
