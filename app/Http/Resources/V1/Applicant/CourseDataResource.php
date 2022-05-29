<?php

namespace App\Http\Resources\V1\Applicant;

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
            'first_choice_course' => $this->dipCourseDataFirstChoice->first() == null ? null : new CourseResource($this->dipCourseDataFirstChoice->first()),
            'second_choice_course' => $this->dipCourseDataSecondChoice->first() == null ? null :new CourseResource($this->dipCourseDataSecondChoice->first()),
            'status' => $this->status
        ];
    }
}
