<?php

namespace App\Http\Requests\V1\Applicant\ApplicationPayment;

use App\Http\Requests\Base\BaseFormRequest;

class ApplicationPaymentRequest extends BaseFormRequest
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
