<?php

namespace App\Services\Implementations\Students;

use App\Models\NceContactData;
use App\Services\Interfaces\Students\ContactDataServiceInterface;

class ContactDataServiceImplementation implements ContactDataServiceInterface
{
    public function getContactDataByUserId($userId)
    {
        return NceContactData::where([
            'user_id' => $userId
        ])->first();
    }
    
    public function updateContactData($contactData)
    {
        $contactData->save();
    }
}
