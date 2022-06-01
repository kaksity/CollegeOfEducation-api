<?php

namespace App\Http\Controllers\V1\Student\Diploma;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Certificate\CertificateRequest;
use App\Http\Resources\V1\Certificate\CertificateResource;
use Illuminate\Http\Request;
use App\Models\Certificate;
use Exception;

class CertificateController extends Controller
{
    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $certificates = $this->certificate->latest()->get();
        return CertificateResource::collection($certificates);        
    }
}
