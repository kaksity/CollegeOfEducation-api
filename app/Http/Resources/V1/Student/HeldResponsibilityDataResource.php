<?php

namespace App\Http\Resources\V1\Nce\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class HeldResponsibilityDataResource extends JsonResource
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
            'responsibility' => $this->responsibility
        ];
    }
}
