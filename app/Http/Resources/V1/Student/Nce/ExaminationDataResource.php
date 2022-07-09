<?php

namespace App\Http\Resources\V1\Student\Nce;

use App\Http\Resources\V1\ExaminationCategory\ExaminationCategoryResource;
use App\Http\Resources\V1\ExaminationSubject\ExaminationSubjectResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ExaminationDataResource extends JsonResource
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
            'examination_category' => new ExaminationCategoryResource($this->examinationCategory),
            'examination_subject' => new ExaminationSubjectResource($this->examinationSubject),
            'grade' => $this->grade,
        ];
    }
}
