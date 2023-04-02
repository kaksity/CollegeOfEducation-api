<?php

namespace App\Http\Requests\V1\Applicant\Authentication;

use App\Http\Requests\Base\BaseFormRequest;

class ChangePasswordRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'old_password' => ['required','string','min:8'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
