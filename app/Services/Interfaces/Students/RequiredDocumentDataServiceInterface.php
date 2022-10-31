<?php

namespace App\Services\Interfaces\Students;

interface RequiredDocumentDataServiceInterface 
{
    public function getRequiredDocumentDataByUserId($userId);
    public function getRequiredDocumentDataById($requiredDocumentDataId);
    public function checkIfRequiredDocumentHasBeenUploaded($requiredDocumentId, $userId);
    public function deleteRequiredDocumentData($requiredDocumentData);
    public function createNewRequiredDocumentData(array $data);
}
