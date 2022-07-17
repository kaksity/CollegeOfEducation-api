<?php

namespace App\Http\Requests\V1\Applicant\NceApplicationPayment;

use App\Http\Requests\Base\BaseFormRequest;

class NceApplicationPaymentRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            //
        ];
        if($this->getMethod() == 'POST')
        {
            $rules += [
                'payment_gateway' => ['required', 'in:remita,interswitch']
            ];
        }
        return $rules;
    }
}
