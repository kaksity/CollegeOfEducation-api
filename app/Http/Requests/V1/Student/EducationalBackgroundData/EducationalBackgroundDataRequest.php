<?php

namespace App\Http\Requests\V1\Student\EducationalBackgroundData;

use App\Http\Requests\Base\BaseFormRequest;

class EducationalBackgroundDataRequest extends BaseFormRequest
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
                'per_page' => ['required','integer']
            ];
        }
        if($this->getMethod() == 'POST')
        {
            $rules += [
                'name_of_institute' => ['required', 'string'],
                'from_date' => ['required', 'date_format:Y-m-d'],
                'to_date' => ['required', 'date_format:Y-m-d'],
                'certificate_id' => ['required', 'uuid']
            ];
        }

        return $rules;
    }
}
