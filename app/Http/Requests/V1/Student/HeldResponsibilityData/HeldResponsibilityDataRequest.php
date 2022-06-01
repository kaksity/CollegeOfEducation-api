<?php

namespace App\Http\Requests\V1\Student\HeldResponsibilityData;

use App\Http\Requests\Base\BaseFormRequest;
class HeldResponsibilityDataRequest extends BaseFormRequest
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
                'responsibility' => ['required', 'string']
            ];
        }
        return $rules;
    }
}
