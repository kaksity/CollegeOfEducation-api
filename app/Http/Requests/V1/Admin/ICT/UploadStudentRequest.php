<?php

namespace App\Http\Requests\V1\Admin\ICT;

use App\Http\Requests\Base\BaseFormRequest;

class UploadStudentRequest extends BaseFormRequest
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
                'application_tracking_number' => ['required', 'string']
            ];
        }
        if($this->getMethod() == 'PUT')
        {
            $rules += [
                'id_number' => ['required', 'string']
            ];
        }
        return $rules;
    }
}
