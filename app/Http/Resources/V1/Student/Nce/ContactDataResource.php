<?php

namespace App\Http\Resources\V1\Student\Nce;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_of_guardian' => $this->name_of_guardian,
            'address_of_guardian' => $this->address_of_guardian,
            'name_of_employer' => $this->name_of_employer,
            'address_of_employer' => $this->address_of_employer,
            'contact_address' => $this->contact_address,
            'phone_number' => $this->phone_number,
            'email_address' => $this->email_address
        ];
    }
}
