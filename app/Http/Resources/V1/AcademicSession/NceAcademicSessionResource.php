<?php

namespace App\Http\Resources\V1\AcademicSession;

use App\Http\Resources\V1\CourseGroup\CourseGroupResource;
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
            'course_group' => new CourseGroupResource($this->courseGroup),
            'start_year' => $this->start_year,
            'end_year' => $this->end_year
        ];
    }
}
