<?php

namespace App\Http\Requests\V1\CourseSubject;

use App\Http\Requests\Base\BaseFormRequest;

class CourseSubjectRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [];

        if($this->getMethod() == 'GET')
        {
            $rules += [
                'course_id' => ['uuid'],
                'semester' => ['in:first,second'],
            ];
        }
        if($this->getMethod() == 'POST')
        {
            $rules += [
                'course_unit' => ['required', 'integer'],
                'course_title' => ['required', 'string'],
                'course_code' => ['required', 'string'],
                'semester' => ['required', 'in:first,second'],
                'course_id' => ['required', 'uuid']
            ];
        }
        return $rules;
    }
}
