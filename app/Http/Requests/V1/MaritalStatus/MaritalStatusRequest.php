<?php

namespace App\Http\Requests\V1\MaritalStatus;

use App\Http\Requests\Base\BaseFormRequest;

class MaritalStatusRequest extends BaseFormRequest
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
