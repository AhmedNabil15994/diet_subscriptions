<?php

namespace Modules\Package\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $response = [
            'package' => 'required|exists:packages,id',
            'price_id' => 'required|exists:package_prices,id',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'street' => 'required',
            'block' => 'required',
            'building' => 'required',
//            'gada' => 'required',
        ];

        if (isset($this->request->all()['client_type']) && $this->request->all()['client_type'] == 'create') {
            request()->merge(['user_mobile' => "+".request()->user_mobile]);
            $response['user_mobile'] = 'required|unique:users,mobile';
            $response['user_name'] = 'required';
        }
//        else {
//            $response['user_id'] = 'required|exists:users,id';
//        }

        return $response;
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
