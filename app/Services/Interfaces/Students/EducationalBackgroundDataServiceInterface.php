<?php

namespace App\Services\Interfaces\Students;

interface EducationalBackgroundDataServiceInterface
{
    public function createNewEducationalBackgroundData(array $data);
    public function getEducationalBackgroundById($educationalBackgroundDataId);
    public function getEducationalBackgroundByUserId($userId, $perPage);
    public function deleteEducationalBackgroundData($educationalBackgroundData);
}
