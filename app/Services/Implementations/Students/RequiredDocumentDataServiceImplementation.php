<?php

namespace App\Services\Implementations\Students;

use App\Models\NceRequiredDocumentData;
use App\Services\Interfaces\Students\RequiredDocumentDataServiceInterface;

class RequiredDocumentDataServiceImplementation implements RequiredDocumentDataServiceInterface
{
    public function getRequiredDocumentDataByUserId($userId)
    {
        return NceRequiredDocumentData::with(['requiredDocument'])->where([
            'user_id' => $userId,
        ])->get();
    }
    public function getRequiredDocumentDataById($requiredDocumentDataId)
    {
        return NceRequiredDocumentData::where([
            'id' => $requiredDocumentDataId
        ])->first();
    }

    public function deleteRequiredDocumentData($requiredDocumentData)
    {
        $requiredDocumentData->delete();
    }
    public function checkIfRequiredDocumentHasBeenUploaded($requiredDocumentId, $userId)
    {
        $requiredDocumentData = NceRequiredDocumentData::where([
            'user_id' => $userId,
            'required_document_id' => $requiredDocumentId
        ])->first();

        return $requiredDocumentData != null;
    }

    public function createNewRequiredDocumentData(array $data)
    {
        NceRequiredDocumentData::create($data);
    }
}
