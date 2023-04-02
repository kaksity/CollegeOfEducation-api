<?php

namespace App\Http\Requests\V1\State;

use App\Http\Requests\Base\BaseFormRequest;

class StateRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [];
        if($this->getMethod() == 'POST' || $this->getMethod() == 'PUT')
        {
            $rules += [
                'is_default_state' => ['required', 'boolean'],
                'name' => ['required']
            ];
        }
        return $rules;
    }
}
