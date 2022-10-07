<?php

namespace App\Http\Resources\V1\Applicant\Nce;

use App\Http\Resources\V1\Certificate\CertificateResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationalBackgroundDataResource extends JsonResource
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
            'name_of_institute' => $this->name_of_institute,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'certificate' => new CertificateResource($this->certificate)
        ];
    }
}
