<?php

namespace App\Http\Resources\V1\Student\Nce;

use Illuminate\Http\Resources\Json\JsonResource;

class PassportResource extends JsonResource
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
            'path' => $this->file_path == null ?  env('APP_URL').'/image/user-placeholder.png' : env('APP_URL').'/storage/passports/'.$this->file_path,
        ];
    }
}
