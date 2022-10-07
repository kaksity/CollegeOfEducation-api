<?php

namespace App\Http\Requests\V1\Admin\Applicant;

use App\Http\Requests\Base\BaseFormRequest;

class ApplicantRequest extends BaseFormRequest
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
                'per_page' => ['required', 'integer', 'min:0', 'max:100'],
                'status' => ['required', 'in:applied,admitted,rejected'],
                'id_number' => ['string']
            ];
        }
        if($this->getMethod() == 'PUT')
        {
            $rules += [
                'admitted_course_id' => ['uuid'],
                'status' => ['required', 'in:admitted,rejected'],
            ];
        }
        return $rules;
    }
}
