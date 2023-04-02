<?php

namespace App\Http\Requests\V1\Student\ExtraCurricularActivityData;

use App\Http\Requests\Base\BaseFormRequest;

class ExtraCurricularActivityDataRequest extends BaseFormRequest
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
                'per_page' => ['string']
            ];
        }
        if($this->getMethod() == 'POST')
        {
            $rules += [
                'activity' => ['required', 'string']
            ];
        }
        return $rules;
    }
}
