<?php

namespace App\Http\Resources\V1\Admin\ICT;

use App\Http\Resources\V1\Admin\ApplicantDetailResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UploadStudentResource extends JsonResource
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
            'user' => new ApplicantDetailResource($this->user)
        ];
    }
}
