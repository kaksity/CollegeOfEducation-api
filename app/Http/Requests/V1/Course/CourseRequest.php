<?php

namespace App\Http\Requests\V1\Course;

use App\Http\Requests\Base\BaseFormRequest;

class CourseRequest extends BaseFormRequest
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
                'name' => ['required', 'string']
            ];
        }
        return $rules;
    }
}
