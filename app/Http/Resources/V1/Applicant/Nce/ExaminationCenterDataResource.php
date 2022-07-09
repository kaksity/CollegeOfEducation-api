<?php

namespace App\Http\Resources\V1\Nce\Applicant;

use Illuminate\Http\Resources\Json\JsonResource;

class ExaminationCenterDataResource extends JsonResource
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
            'center_number' => $this->center_number,
            'date_of_examination' => $this->date_of_examination,
            'examination_number' => $this->examination_number,
            'overall_result' => $this->overall_result,
        ];
    }
}
