<?php

namespace App\Http\Resources\V1\Nce\ExaminationSubject;

use App\Http\Resources\V1\ExaminationCategory\ExaminationCategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ExaminationSubjectResource extends JsonResource
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
            'category' => new ExaminationCategoryResource($this->category),
            'subject' => $this->subject
        ];
    }
}
