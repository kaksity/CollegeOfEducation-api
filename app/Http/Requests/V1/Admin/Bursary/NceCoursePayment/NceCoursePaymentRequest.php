<?php

namespace App\Http\Requests\V1\Admin\Bursary\NceCoursePayment;

use App\Http\Requests\Base\BaseFormRequest;

class NceCoursePaymentRequest extends BaseFormRequest
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
                'per_page' => ['integer']
            ];
        }
        if($this->getMethod() == 'POST')
        {
            $rules += [
                'course_id' => ['required', 'uuid'],
                'amount' => ['required', 'numeric'],
                'is_indigine' => ['required', 'boolean'],
                'year_group' => ['required', 'string'],
                'remita_service_type' => ['required', 'string']
            ];
        }
        if($this->getMethod() == 'PUT')
        {
            $rules += [
                'amount' => ['required', 'numeric']
            ];
        }
        return $rules;
    }
}
