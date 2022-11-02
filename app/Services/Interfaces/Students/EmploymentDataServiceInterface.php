<?php

namespace App\Services\Interfaces\Students;

interface EmploymentDataServiceInterface
{
    public function createNewEmploymentData(array $data);
    public function getEmploymentDataById($employmentDataId);
    public function getEmploymentDataByUserId($userId, $perPage);
    public function deleteEmploymentData($employmentData);
}
