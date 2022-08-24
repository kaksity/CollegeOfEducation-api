<?php

namespace App\Http\Resources\V1\Student\Nce;

use App\Http\Resources\V1\Applicant\Nce\ExaminationCenterDataResource;
use App\Models\NceApplicationStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'id_number' => $this->nceApplicationStatus->id_number,
            'personal_data' => new PersonalDataResource($this->ncePersonalData),
            'contact_data' => new ContactDataResource($this->nceContactData),
        ];
    }
}
