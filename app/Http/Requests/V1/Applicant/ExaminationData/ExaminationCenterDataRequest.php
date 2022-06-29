<?php

namespace App\Http\Requests\V1\Applicant\ExaminationData;

use App\Http\Requests\Base\BaseFormRequest;

class ExaminationCenterDataRequest extends BaseFormRequest
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
                'center_number' => ['required', 'string'],
                'examination_number' => ['required', 'string'],
                'date_of_examination' => ['required', 'date_format:Y-m-d'],
                'overall_result' => ['required', 'string'],
            ];
        }
        return $rules;
    }
}
