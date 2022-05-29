<?php

namespace App\Http\Requests\V1\ExaminationSubject;

use App\Http\Requests\Base\BaseFormRequest;

class ExaminationSubjectRequest extends BaseFormRequest
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
                'per_page' => ['required','integer'],
                'examination_category_id' => ['uuid'],
            ];
        }
        if($this->getMethod() == 'POST')
        {
            $rules += [
                'examination_category_id' => ['required','uuid'],
                'subject' => ['required', 'string']
            ];
        }
        return $rules;
    }
}
