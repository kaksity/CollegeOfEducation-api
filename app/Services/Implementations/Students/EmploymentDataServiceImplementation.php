<?php
namespace App\Services\Implementations\Students;

use App\Models\NceEmploymentData;

use App\Services\Interfaces\Students\EmploymentDataServiceInterface;

class EmploymentDataServiceImplementation implements EmploymentDataServiceInterface
{
    public function createNewEmploymentData(array $data)
    {
        NceEmploymentData::create($data);
    }
    public function getEmploymentDataById($employmentDataId)
    {
        return NceEmploymentData::where([
            'id' => $employmentDataId
        ])->first();
    }
    public function getEmploymentDataByUserId($userId, $perPage)
    {
        return NceEmploymentData::where([
            'user_id' => $userId
        ])->latest()->paginate($perPage);
    }
    public function deleteEmploymentData($employmentData)
    {
        $employmentData->delete();
    }
}
