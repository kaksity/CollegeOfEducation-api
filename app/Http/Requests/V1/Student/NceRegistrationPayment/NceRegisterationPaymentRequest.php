<?php

namespace App\Http\Requests\V1\Student\NceRegistrationPayment;

use App\Http\Requests\Base\BaseFormRequest;

class NceRegisterationPaymentRequest extends BaseFormRequest
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
                'payment_gateway' => ['required', 'in:interswitch']
            ];
        }
        return $rules;
    }
}
