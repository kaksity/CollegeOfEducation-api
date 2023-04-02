<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RequiredDocument\RequiredDocumentRequest;
use App\Http\Resources\V1\RequiredDocument\RequiredDocumentResource;
use App\Models\RequiredDocument;
use App\Services\Interfaces\GeneralSettings\RequiredDocumentServiceInterface;
use Exception;

class RequiredDocumentController extends Controller
{
    public function __construct(private RequiredDocumentServiceInterface $requiredDocumentServiceInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requiredDocuments = $this->requiredDocumentServiceInterface->getAllRequiredDocuments();
        return RequiredDocumentResource::collection($requiredDocuments);
    }
    
}
