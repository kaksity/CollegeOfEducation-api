<?php

namespace App\Http\Resources\V1\Applicant\Nce;

use App\Http\Resources\V1\RequiredDocument\RequiredDocumentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RequiredDocumentDataResource extends JsonResource
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
            'required_document' => new RequiredDocumentResource($this->requiredDocument),
            'file_path' => env('APP_URL')."/storage/reqdocs/".$this->file_path,
        ];
    }
}
