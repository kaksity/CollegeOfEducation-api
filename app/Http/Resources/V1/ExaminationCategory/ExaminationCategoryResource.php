<?php

namespace App\Http\Resources\V1\Nce\ExaminationCategory;

use Illuminate\Http\Resources\Json\JsonResource;

class ExaminationCategoryResource extends JsonResource
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
            'category' => $this->category
        ];
    }
}
