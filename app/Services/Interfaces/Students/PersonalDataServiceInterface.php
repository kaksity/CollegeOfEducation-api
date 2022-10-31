<?php

namespace App\Services\Interfaces\Students;

interface PersonalDataServiceInterface
{
    public function getPersonalDataByUserId($userId);
    public function updatePersonalData($personalData);
}
