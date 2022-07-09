<?php

namespace App\Http\Resources\V1\Nce\Applicant;

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
            'first_choice_course' => $this->dipCourseDataFirstChoice == null ? null : new CourseResource($this->dipCourseDataFirstChoice),
            'second_choice_course' => $this->dipCourseDataSecondChoice == null ? null : new CourseResource($this->dipCourseDataSecondChoice),
            'third_choice_course' => $this->dipCourseDataThirdChoice == null ? null : new CourseResource($this->dipCourseDataThirdChoice),
            'admitted_course' => $this->dipCourseDataAdmittedCourse == null ? null : new CourseResource($this->dipCourseDataAdmittedCourse)
        ];
    }
}