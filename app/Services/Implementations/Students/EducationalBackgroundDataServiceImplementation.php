<?php

namespace App\Services\Implementations\Students;

use App\Models\NceEducationalBackgroundData;
use App\Services\Interfaces\Students\EducationalBackgroundDataServiceInterface;

class EducationalBackgroundDataServiceImplementation implements EducationalBackgroundDataServiceInterface
{
    public function createNewEducationalBackgroundData(array $data)
    {
        NceEducationalBackgroundData::create($data);
    }
    public function getEducationalBackgroundById($educationalBackgroundDataId)
    {
        return NceEducationalBackgroundData::where([
            'id' => $educationalBackgroundDataId
        ])->first();
    }
    public function getEducationalBackgroundByUserId($userId, $perPage)
    {
        return NceEducationalBackgroundData::where([
            'user_id' => $userId
        ])->latest()->paginate($perPage);
    }
    public function deleteEducationalBackgroundData($educationalBackgroundData)
    {
        $educationalBackgroundData->delete();
    }
}
