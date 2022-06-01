<?php

namespace App\Http\Resources\V1\CourseSubject;

use App\Http\Resources\V1\Course\CourseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseSubjectResource extends JsonResource
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
            'course' => new CourseResource($this->course), 
            'course_title' => $this->course_title,
            'course_code' => $this->course_code,
            'semester' => $this->semester,
        ];
    }
}
