<?php

namespace App\Services\Implementations\GeneralSettings;

use App\Models\RequiredDocument;
use App\Services\Interfaces\GeneralSettings\RequiredDocumentServiceInterface;

class RequiredDocumentServiceImplementation implements RequiredDocumentServiceInterface
{
    public function getAllRequiredDocuments()
    {
        return RequiredDocument::latest()->get();
    }

    public function getRequiredDocumentById($requiredDocumentId)
    {
        return RequiredDocument::where([
            'id' => $requiredDocumentId
        ])->first();
    }

    public function createNewRequiredDocument(array $data)
    {
        return RequiredDocument::create($data);
    }

    public function updateRequiredDocument($requiredDocument)
    {
        $requiredDocument->save();
    }

    public function deleteRequiredDocument($requiredDocument)
    {
        $requiredDocument->delete();
    }

}
