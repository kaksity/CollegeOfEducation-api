<?php

namespace App\Http\Requests\V1\Auth;

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
            'email_address' => ['required','string'],
            'password' => ['required','string','min:8']
        ];
    }
}
