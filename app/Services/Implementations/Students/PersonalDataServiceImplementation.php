<?php

namespace App\Services\Implementations\Students;

use App\Models\NcePersonalData;
use App\Services\Interfaces\Students\PersonalDataServiceInterface;

class PersonalDataServiceImplementation implements PersonalDataServiceInterface
{
    public function getPersonalDataByUserId($userId)
    {
        return NcePersonalData::where([
            'user_id' => $userId
        ])->first();
    }

    public function updatePersonalData($personalData)
    {
        $personalData->save();
    }
}
