<?php

namespace App\Http\Requests\V1\Student\Authentication;

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
            'id_number_or_email_address' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8']
        ];
    }
}
