<?php

namespace App\Services\Implementations;

use App\Models\Lga;
use App\Services\Interfaces\LgaServiceInterface;

class LgaServiceImplementation implements LgaServiceInterface
{
    public function getAllLgas($stateId)
    {
        return Lga::when($stateId, function ($model, $stateId) {
            $model->where('state_id', $stateId);
        })->orderBy('name', 'ASC')->get();
    }

    public function createNewLga(array $data)
    {
        return Lga::create($data);
    }

    public function getLgaById($lgaId)
    {
        return Lga::where([
            'id' => $lgaId
        ])->first();
    }

    public function updateLga($lga): void
    {
        $lga->save();
    }

    public function deleteLga($lga): void
    {
        $lga->delete();
    }
}
