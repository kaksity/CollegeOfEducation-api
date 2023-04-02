<?php

namespace App\Http\Requests\V1\Admin\Bursary\ApplicantSetPayment;

use App\Http\Requests\Base\BaseFormRequest;

class ApplicantSetPaymentRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [];

        if($this->getMethod() == 'POST')
        {
            $rules += [
                'course_group_id' => ['required', 'uuid'],
                'amount' => ['required', 'numeric', 'min:0'],
                'remita_service_type' => ['required', 'string'],
            ];
        }
        return $rules;
    }
}
