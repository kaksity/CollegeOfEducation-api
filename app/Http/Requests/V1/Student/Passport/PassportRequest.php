<?php

namespace App\Http\Requests\V1\Student\Passport;

use App\Http\Requests\Base\BaseFormRequest;

class PassportRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => ['required','image','mimes:jpeg,png,jpg','max:100'],
        ];
    }
}
