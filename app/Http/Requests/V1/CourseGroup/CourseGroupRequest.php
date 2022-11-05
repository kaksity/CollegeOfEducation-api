<?php

namespace App\Http\Requests\V1\CourseGroup;

use App\Http\Requests\Base\BaseFormRequest;

class CourseGroupRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [];
        if($this->getMethod() == 'POST' || $this->getMethod() == 'PUT')
        {
            $rules += [
                'name' => ['required', 'string'],
                'code' => ['required', 'string'],
                'number_of_years' => ['required']
            ];
        }
        return $rules;
    }
}
