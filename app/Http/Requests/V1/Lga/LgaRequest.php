<?php

namespace App\Http\Requests\V1\Lga;

use App\Http\Requests\Base\BaseFormRequest;

class LgaRequest extends BaseFormRequest
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
                'state_id' => ['uuid']
            ];
        }
        if($this->getMethod() == 'POST')
        {
            $rules += [
                'state_id' => ['required','uuid'],
                'name' => ['required']
            ];
        }
        if($this->getMethod() == 'PUT')
        {
            $rules += [
                'name' => ['required']
            ];
        }
        return $rules;
    }
}
