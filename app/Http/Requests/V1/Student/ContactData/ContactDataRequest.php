<?php

namespace App\Http\Requests\V1\Student\ContactData;

use App\Http\Requests\Base\BaseFormRequest;

class ContactDataRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name_of_guardian' => ['required','string'],
            'address_of_guardian' => ['required','string'],
            'name_of_employer' => ['string'],
            'address_of_employer' => ['string'],
            'contact_address' => ['required','string'],
            'email_address' => ['required','string'],
            'phone_number' => ['required', 'string']
        ];
    }
}
