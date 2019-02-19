<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRegistrationPostRequest extends FormRequest
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
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|max:16',
            'address' => 'required|max:100',
            'address_2' => 'max:100',
            'suite' => 'max:50',
            'city' => 'required|max:100',
            'state' => 'required|max:3',
            'postal' => 'required|max:10',
            'country' => 'required|max:2',
            'emergency_contact_name' => 'required|max:100',
            'emergency_contact_phone' => 'required|max:16',
            'emergency_contact_relation' => 'required|max:50',
            'total' => 'required|integer',
        ];
    }
}
