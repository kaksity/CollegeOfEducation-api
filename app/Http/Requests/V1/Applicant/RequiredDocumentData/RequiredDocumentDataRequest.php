<?php

namespace App\Http\Requests\V1\Applicant\RequiredDocumentData;

use App\Http\Requests\Base\BaseFormRequest;

class RequiredDocumentDataRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'required_document_id' => ['required', 'uuid'],
            'file' => ['required','image','mimes:jpeg,png,jpg','max:100'],
        ];
    }
}
