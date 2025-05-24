<?php

namespace Modules\Authentication\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->try_verified !== 'try_verified') {
            return [
                'name'               => 'required',
                'mobile'             => 'required|unique:users,mobile|phone:AUTO',
                'email'              => 'nullable|email|unique:users,email',
                'mobile_country'     => 'required',
                'password'           => 'nullable|confirmed|min:6',
            ];
        } else {
            return [
                'mobile'             => 'required|exists:users,mobile|phone:AUTO',
                'code_verified'      => 'required',
            ];
        }
    }
}
