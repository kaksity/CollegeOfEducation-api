<?php

namespace App\Http\Resources\V1\CourseGroup;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseGroupResource extends JsonResource
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
            'number_of_years' => $this->number_of_years,
            'code' => $this->code,
            'name' => $this->name
        ];
    }
}
