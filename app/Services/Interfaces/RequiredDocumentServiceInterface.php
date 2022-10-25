<?php

namespace App\Services\Interfaces;

interface RequiredDocumentServiceInterface
{
    public function getAllRequiredDocuments();
    public function getRequiredDocumentById($requiredDocumentId);
    public function createNewRequiredDocument(array $data);
    public function updateRequiredDocument($requiredDocument);
    public function deleteRequiredDocument($requiredDocument);
}
