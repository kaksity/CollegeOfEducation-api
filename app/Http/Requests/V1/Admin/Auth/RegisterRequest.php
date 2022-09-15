<?php
namespace App\Http\Requests\V1\Admin\Auth;

use App\Http\Requests\Base\BaseFormRequest;

class RegisterRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email_address' => ['required','string'],
            'password' => ['required','string','min:8', 'confirmed'],
            'role' => ['required', 'in:admission-office,bursary-office,super-admin,ict-office'],
            'first_name' => ['required', 'string','min:3'],
            'last_name' => ['required', 'string', 'min:3']
        ];
    }
}
