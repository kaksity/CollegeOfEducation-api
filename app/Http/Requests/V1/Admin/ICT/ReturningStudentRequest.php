<?php

namespace App\Http\Requests\V1\Admin\ICT;

use App\Http\Requests\Base\BaseFormRequest;

class ReturningStudentRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [];

        if($this->getMethod() == 'POST')
        {
            $rules += [
                'surname' => ['required', 'string', 'min:3'],
                'other_names' => ['required', 'string', 'min:3'],
                'email_address' => ['required', 'email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'course_group_id' => ['required', 'uuid'],
                'course_id' => ['required', 'uuid'],
                'id_number' => ['required', 'string']
            ];
        }
        return $rules;
    }
}
