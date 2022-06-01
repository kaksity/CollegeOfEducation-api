<?php

namespace App\Http\Resources\V1\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationStatusResource extends JsonResource
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
            'status' => $this->status,
            $this->mergeWhen($this->status == 'admitted', function() {
                return [
                    'course' => new CourseDataResource($this->user->dipCourseData),
                ];
            }),
        ];
    }
}
