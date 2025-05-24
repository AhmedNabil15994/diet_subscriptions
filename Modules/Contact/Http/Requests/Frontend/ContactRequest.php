<?php

namespace Modules\Contact\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                  'name'            => 'required',
                  'email'           => 'required',
                  'mobile'          => 'required|phone:AUTO',
                  'desc'            => 'nullable',
                ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
