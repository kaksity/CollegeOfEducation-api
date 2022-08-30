<?php

namespace App\Http\Resources\V1\Admin\Bursary;

use App\Http\Resources\V1\AcademicSession\NceAcademicSessionResource;
use App\Http\Resources\V1\CourseGroup\CourseGroupResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseRegisterationPinResource extends JsonResource
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
            'course_group' => new CourseGroupResource($this->courseGroup),
            'used_counter' => $this->used_counter,
            'serial_number' => $this->serial_number,
            'pin' => $this->pin,
            'status' => $this->status,
            'academic_session' => new NceAcademicSessionResource($this->academicSession),
        ];
    }
}
