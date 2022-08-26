<?php

namespace App\Http\Requests\V1\Applicant\Authentication;

use App\Http\Requests\Base\BaseFormRequest;

class LoginRequest extends BaseFormRequest
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
            'password' => ['required', 'string', 'min:8']
        ];
    }
}
