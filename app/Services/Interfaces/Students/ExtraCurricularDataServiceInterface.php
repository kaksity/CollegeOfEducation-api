<?php

namespace App\Services\Interfaces\Students;

interface ExtraCurricularDataServiceInterface
{
    public function createNewExtraCurricularActivity(array $data);
    public function getExtraCurricularActivityById($extraCurricularActivityId);
    public function getExtraCurricularActivityByUserId($userId, $perPage);
    public function deleteExtraCurricularActivity($extraCurricularActivity);
}
