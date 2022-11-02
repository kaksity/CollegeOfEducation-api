<?php

namespace App\Services\Implementations\Students;

use App\Models\NceHeldResponsibilityData;
use App\Services\Interfaces\Students\HeldResponsibilityDataServiceInterface;

class HeldResponsibilityDataServiceImplementation implements HeldResponsibilityDataServiceInterface
{
    public function createNewHeldResponsibility(array $data)
    {
        NceHeldResponsibilityData::create($data);
    }
    public function getHeldResponsibilityById($heldResponsibilityId)
    {
        return NceHeldResponsibilityData::where([
            'id' => $heldResponsibilityId
        ])->first();
    }
    public function deleteHeldResponsibility($heldResponsibility)
    {
        $heldResponsibility->delete();
    }
    public function getHeldResponsibilityByUserId($userId, $perPage)
    {
        return NceHeldResponsibilityData::where([
            'user_id' => $userId
        ])->latest()->paginate($perPage);
    }
}
