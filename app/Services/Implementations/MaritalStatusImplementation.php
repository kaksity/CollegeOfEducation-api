<?php
namespace App\Services\Implementations;

use App\Models\MaritalStatus;
use App\Services\Interfaces\MaritalStatusInterface;

class MaritalStatusImplementation implements MaritalStatusInterface
{
    public function getAllMaritalStatus()
    {
        return MaritalStatus::latest()->get();
    }

    public function createNewMaritalStatus(array $data): void
    {
        MaritalStatus::create($data);
    }

    public function getMaritalStatusById($maritalStatusId)
    {
        return MaritalStatus::where([
            'id' => $maritalStatusId
        ])->first();
    }

    public function updateMaritalStatus($maritalStatus): void
    {
        $maritalStatus->save();
    }
    public function deleteMaritalStatus($maritalStatus): void
    {
        $maritalStatus->delete();
    }
}
