<?php

namespace App\Http\Requests\V1\Student\Authentication;

use App\Http\Requests\Base\BaseFormRequest;

class VerificationForgotPassword extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email_address' => ['required', 'email'],
            'verification_code' => ['required'],
            'new_password' => ['required', 'min: 8']
        ];
    }
}
