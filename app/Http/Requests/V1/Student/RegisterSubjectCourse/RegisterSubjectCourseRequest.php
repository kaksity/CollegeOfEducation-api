<?php

namespace App\Http\Requests\V1\Student\RegisterSubjectCourse;

use App\Http\Requests\Base\BaseFormRequest;

class RegisterSubjectCourseRequest extends BaseFormRequest
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
                'course_subject_id' => ['required', 'uuid']
            ];
        }
        return $rules;
    }
}
