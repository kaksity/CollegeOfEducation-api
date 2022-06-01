<?php

namespace App\Http\Requests\V1\Student\Authentication;

use App\Http\Requests\Base\BaseFormRequest;

class RegisterRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'surname' => ['required', 'string', 'min:3'],
            'other_names' => ['required', 'string', 'min:3'],
            'email_address' => ['required', 'string', 'min:3'],
            'username' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8']
        ];
    }
}
