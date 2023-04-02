<?php

namespace App\Http\Requests\V1\Applicant\Authentication;

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
            'email_address' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'course_group_id' => ['required', 'uuid'],
            'state_id' => ['required', 'uuid']
        ];
    }
}
