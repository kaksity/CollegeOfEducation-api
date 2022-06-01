<?php

namespace App\Http\Requests\V1\Student\PersonalData;

use App\Http\Requests\Base\BaseFormRequest;

class PersonalDataRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'surname' => ['required', 'string'],
            'other_names' => ['required', 'string'],
            'date_of_birth' => ['required', 'date_format:Y-m-d'],
            'place_of_birth' => ['required', 'string'],
            'sex' => ['required','string','in:Male,Female'],
            'marital_status_id' => ['required', 'uuid'],
            'home_town' => ['required', 'string'],
            'state_id' => ['required','uuid'],
            'lga_id' => ['required','uuid'],
            'nationality' => ['required','string']
        ];
    }
}
