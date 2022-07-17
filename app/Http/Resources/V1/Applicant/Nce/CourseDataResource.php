<?php

namespace App\Http\Resources\V1\Applicant\Nce;

use App\Http\Resources\V1\Course\CourseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseDataResource extends JsonResource
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
            'first_choice_course' => $this->NceCourseDataFirstChoice == null ? null : new CourseResource($this->NceCourseDataFirstChoice),
            'second_choice_course' => $this->NceCourseDataSecondChoice == null ? null : new CourseResource($this->NceCourseDataSecondChoice),
            'third_choice_course' => $this->NceCourseDataThirdChoice == null ? null : new CourseResource($this->NceCourseDataThirdChoice),
            'admitted_course' => $this->NceCourseDataAdmittedCourse == null ? null : new CourseResource($this->NceCourseDataAdmittedCourse)
        ];
    }
}