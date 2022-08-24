<?php

namespace App\Http\Resources\V1\AcademicSession;

use Illuminate\Http\Resources\Json\JsonResource;

class NceAcademicSessionResource extends JsonResource
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
            'start_year' => $this->start_year,
            'end_year' => $this->end_year
        ];
    }
}
