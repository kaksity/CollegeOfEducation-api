<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RequiredDocument\RequiredDocumentRequest;
use App\Http\Resources\V1\RequiredDocument\RequiredDocumentResource;
use App\Models\RequiredDocument;
use Exception;

class RequiredDocumentController extends Controller
{
    public function __construct(RequiredDocument $requiredDocument)
    {
        $this->requiredDocument = $requiredDocument;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requiredDocuments = $this->requiredDocument->latest()->get();
        return RequiredDocumentResource::collection($requiredDocuments);        
    }
    
}
