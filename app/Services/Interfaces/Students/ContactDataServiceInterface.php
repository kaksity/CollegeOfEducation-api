<?php

namespace App\Services\Interfaces\Students;

interface ContactDataServiceInterface
{
    public function getContactDataByUserId($userId);
    
    public function updateContactData($contactData);
}
