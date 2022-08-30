<?php

namespace App\Http\Requests\V1\Admin\Bursary\CourseRegisterationPin;

use App\Http\Requests\Base\BaseFormRequest;

class CourseRegisterationPinRequest extends BaseFormRequest
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
                'per_page' => ['max: 500'],
            ];
        }
        if($this->getMethod() == 'POST')
        {
            $rules += [
                'academic_session_id' => ['required', 'uuid'],
                'course_group_id' => ['required', 'uuid'],
                'number_of_cards' => ['required', 'integer'] 
            ];
        }
        if($this->getMethod() == 'PUT')
        {
            $rules += [
                'status' => ['required', 'in:disabled']
            ];
        }
        return $rules;
    }
}
