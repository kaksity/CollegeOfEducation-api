<?php

namespace App\Http\Resources\V1\Lga;

use App\Http\Resources\V1\State\StateResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LgaResource extends JsonResource
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
            'name' => $this->name,
            'state' => new StateResource($this->state),
        ];
    }
}
