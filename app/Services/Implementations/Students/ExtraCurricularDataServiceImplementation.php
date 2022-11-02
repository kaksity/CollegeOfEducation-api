<?php

namespace App\Services\Implementations\Students;

use App\Models\NceExtraCurricularActivityData;
use App\Services\Interfaces\Students\ExtraCurricularDataServiceInterface;

class ExtraCurricularDataServiceImplementation implements ExtraCurricularDataServiceInterface
{
    public function createNewExtraCurricularActivity(array $data)
    {
        NceExtraCurricularActivityData::create($data);
    }
    public function getExtraCurricularActivityById($extraCurricularActivityId)
    {
        return NceExtraCurricularActivityData::where([
            'id' => $extraCurricularActivityId
        ])->first();
    }
    public function getExtraCurricularActivityByUserId($userId, $perPage)
    {
        return NceExtraCurricularActivityData::where([
            'user_id' => $userId
        ])->latest()->paginate($perPage);
    }
    public function deleteExtraCurricularActivity($extraCurricularActivity)
    {
        $extraCurricularActivity->delete();
    }
}
