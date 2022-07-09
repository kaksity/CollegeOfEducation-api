<?php

namespace App\Http\Resources\V1\Nce\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'username' => $this->username,
            'first_name' => $this->admin->first_name,
            'middle_name' => $this->admin->middle_name,
            'last_name' => $this->admin->last_name,
            'email_address' => $this->admin->email_address
        ];
    }
}
