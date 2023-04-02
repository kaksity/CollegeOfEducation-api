<?php

namespace App\Http\Resources\V1\Student\Nce;

use Illuminate\Http\Resources\Json\JsonResource;

class EmploymentDataResource extends JsonResource
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
            'name_of_employer' => $this->name_of_employer,
            'type_of_employment' => $this->type_of_employment,
            'duration' => $this->duration,
            'unit' => $this->unit,
            'average_salary' => $this->average_salary
        ];
    }
}
