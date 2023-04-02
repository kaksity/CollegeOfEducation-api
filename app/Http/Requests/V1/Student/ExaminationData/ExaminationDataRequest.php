<?php

namespace App\Http\Requests\V1\Student\ExaminationData;

use App\Http\Requests\Base\BaseFormRequest;

class ExaminationDataRequest extends BaseFormRequest
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
                'per_page' => ['required', 'integer']
            ];
        }
        if($this->getMethod() == 'POST')
        {
            $rules += [
                'examination_category_id' => ['required', 'uuid'],
                'examination_subject_id' => ['required', 'uuid'],
                'grade' => ['required', 'string'],
            ];
        }
        return $rules;
    }
}
