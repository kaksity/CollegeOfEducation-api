<?php

namespace App\Http\Requests\V1\Applicant\CourseData;

use App\Http\Requests\Base\BaseFormRequest;

class CourseDataRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_choice_course_id' => ['required', 'uuid'],
            'second_choice_course_id' => ['required', 'uuid'],
            'third_choice_course_id' => ['required', 'uuid']
        ];
    }
}
