<?php

namespace App\Http\Resources\V1\Admin\ICT;

use App\Http\Resources\V1\Applicant\Nce\CourseDataResource;
use App\Http\Resources\V1\Applicant\Nce\PersonalDataResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'personal_data' => new PersonalDataResource($this->ncePersonalData),
            'course_data' => new CourseDataResource($this->nceCourseData),
            'email_address' => $this->email_address,
            'id_number' => $this->id_number
        ];
    }
}
