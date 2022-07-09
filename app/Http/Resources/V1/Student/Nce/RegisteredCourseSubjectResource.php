<?php

namespace App\Http\Resources\V1\Student\Nce;

use App\Http\Resources\V1\CourseSubject\CourseSubjectResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisteredCourseSubjectResource extends JsonResource
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
            'course_subject' => new CourseSubjectResource($this->courseSubject)
        ];
    }
}
