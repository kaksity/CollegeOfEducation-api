<?php

namespace App\Http\Requests\V1\Auth;

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
            'email_address' => ['required','string'],
            'password' => ['required','string','min:8', 'confirmed'],
            'course_group_id' => ['required', 'uuid'],
            'role' => ['required', 'in:admission-office,bursary-office,super-admin'],
            'first_name' => ['required', 'string','min:3'],
            'last_name' => ['required', 'string', 'min:3']
        ];
    }
}
