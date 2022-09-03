<?php
namespace App\Http\Requests\V1\Student\CourseRegisterationPin;
use App\Http\Requests\Base\BaseFormRequest;

class CourseRegisterationPinRequest extends BaseFormRequest
{
    public function rules()
    {
        $rules = [];
        if($this->getMethod() == 'POST')
        {
            $rules += [
                'course_registeration_pin' => ['required', 'string']
            ];
        }
        return $rules;
    }
}