<?php

namespace App\Http\Resources\V1\Admin;

use App\Http\Resources\V1\Applicant\Nce\PersonalDataResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $NcePersonalData = $this->user->NcePersonalData;
        return [
            'id' => $this->user_id,
            'personal_data' => new PersonalDataResource($NcePersonalData),
            $this->mergeWhen($this->user->id_number != null, function() {
                return [
                    'id_number' => $this->user->id_number
                ];
            })
        ];
    }
}
