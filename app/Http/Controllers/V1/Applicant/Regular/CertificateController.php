<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Certificate\CertificateResource;
use App\Services\Interfaces\GeneralSettings\CertificateServiceInterface;

class CertificateController extends Controller
{
    public function __construct(private CertificateServiceInterface $certificateServiceInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $certificates = $this->certificateServiceInterface->getAllCertificates();
        return CertificateResource::collection($certificates);
    }
}
