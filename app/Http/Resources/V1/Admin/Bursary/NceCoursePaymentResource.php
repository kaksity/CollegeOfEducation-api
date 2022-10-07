<?php

namespace App\Http\Resources\V1\Admin\Bursary;

use App\Http\Resources\V1\Course\CourseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NceCoursePaymentResource extends JsonResource
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
            'course' => new CourseResource($this->nceCourse),
            'amount' => $this->amount,
        ];
    }
}
