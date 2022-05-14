<?php

namespace App\Http\Requests\V1\Certificate;

use App\Http\Requests\Base\BaseFormRequest;

class CertificateRequest extends BaseFormRequest
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
                'per_page' => ['integer'],
            ];
        }
        if($this->getMethod() == 'POST' || $this->getMethod() == 'PUT')
        {
            $rules += [
                'name' => ['required']
            ];
        }
        return $rules;
    }
}
