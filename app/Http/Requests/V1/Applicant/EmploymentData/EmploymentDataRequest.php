<?php

namespace App\Http\Requests\V1\Applicant\EmploymentData;

use App\Http\Requests\Base\BaseFormRequest;

class EmploymentDataRequest extends BaseFormRequest
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
                'name_of_employer' => ['required', 'string'],
                'type_of_employment' => ['string'],
                'duration' => ['integer'],
                'unit' => ['in:Months,Years'],
                'average_salary' => ['numeric']
            ];
        }
        return $rules;
    }
}
