<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressRequest extends FormRequest
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
        return [
            'name' => 'required|max:255',
            'address' => 'required',
            'postal_code' => 'required|max:255',
            'province' => 'required|max:255',
            'city' => 'required|max:255',
            'district' => 'required|max:255',
            'phone' => 'required|max:255',
            'province_id' => 'required|numeric',
            'city_id' => 'required|numeric',
        ];
    }
}
