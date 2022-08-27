<?php

namespace App\Http\Requests\V1\AcademicSession;

use App\Http\Requests\Base\BaseFormRequest;

class NceAcademicSessionRequest extends BaseFormRequest
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
                'course_group_id' => ['required', 'uuid'],
                'start_year' => ['required', 'integer'],
                'end_year' => ['required', 'integer']
            ];
        }
        return $rules;
    }
}
