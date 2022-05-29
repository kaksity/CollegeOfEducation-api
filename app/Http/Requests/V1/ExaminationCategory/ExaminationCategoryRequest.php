<?php

namespace App\Http\Requests\V1\ExaminationCategory;

use App\Http\Requests\Base\BaseFormRequest;

class ExaminationCategoryRequest extends BaseFormRequest
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
        if($this->getMethod() == 'POST' || $this->getMethod() == 'PUT')
        {
            $rules += [
                'category' => ['required', 'string']
            ];
        }
        return $rules;
    }
}
