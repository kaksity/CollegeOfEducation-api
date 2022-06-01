<?php

namespace App\Http\Resources\V1\Student;

use App\Http\Resources\V1\Lga\LgaResource;
use App\Http\Resources\V1\MaritalStatus\MaritalStatusResource;
use App\Http\Resources\V1\State\StateResource;
use App\Models\Lga;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class PersonalDataResource extends JsonResource
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
            'surname' => $this->surname,
            'other_names' => $this->other_names,
            'date_of_birth' => $this->date_of_birth,
            'place_of_birth' => $this->place_of_birth,
            'sex' => $this->sex,
            'marital_status' => ($this->maritalStatus == null ) ? null : new MaritalStatusResource($this->maritalStatus),
            'home_town' => $this->home_town,
            'state' => $this->state == null ? null : new StateResource($this->state),
            'lga' => $this->lga == null ? null : new LgaResource($this->lga),
            'nationality' => $this->nationality
        ];
    }
}
