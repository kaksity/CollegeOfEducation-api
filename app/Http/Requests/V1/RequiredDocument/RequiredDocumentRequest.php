<?php

namespace App\Http\Requests\V1\RequiredDocument;

use App\Http\Requests\Base\BaseFormRequest;

class RequiredDocumentRequest extends BaseFormRequest
{
    public function rules()
    {
        $rules = [];
        if($this->getMethod() == 'POST')
        {
            $rules += [
                'name' => ['required', 'string']
            ];
        }
        return $rules;
    }
}
