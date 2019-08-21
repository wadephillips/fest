<?php

namespace App\Http\Requests;

use function dd;
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
      $rules = [
          'token' => 'required|array',
          'token.card.id' => 'required|string',
          'total' => 'required|integer',
          'registrants' => 'required|array',
          'registrants.*.name' => 'required|max:100',
          'registrants.*.email' => 'required|email|max:100',
          'registrants.*.phone' => 'required|max:16',
          'registrants.*.address' => 'required|max:100',
          'registrants.*.address_2' => 'max:100',
          'registrants.*.suite' => 'max:50',
          'registrants.*.city' => 'required|max:100',
          'registrants.*.state' => 'required|max:3',
          'registrants.*.postal' => 'required|max:10',
          'registrants.*.country' => 'required|max:2',
          'registrants.*.emergency_contact_name' => 'required|max:100',
          'registrants.*.emergency_contact_phone' => 'required|max:16',
          'registrants.*.emergency_contact_relationship' => 'required|max:50',
          'registrants.*.amount' => 'required|integer',
          'registrants.*.license_number' => 'nullable|string',
          'description' => 'nullable|string',
      ];
        return $rules;
    }
}
