<?php

namespace Modules\Contact\Http\Requests\Dashboard;

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
            'name'   => 'required|string',
            'email'  => 'required|email',
            'desc'   => 'required|string',
            'mobile' => 'required'
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

    public function messages()
    {
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title." . $key . ".required"]  =
                __('contact::dashboard.contacts.validation.title.required') . ' - ' . $value['native'] . '';


            $v["description." . $key . ".required"]  =
                __('contact::dashboard.contacts.validation.description.required') . ' - ' . $value['native'] . '';
        }

        return $v;
    }
}
