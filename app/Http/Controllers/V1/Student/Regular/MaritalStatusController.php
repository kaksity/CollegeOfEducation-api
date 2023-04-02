<?php

namespace App\Http\Controllers\V1\Student\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MaritalStatus\MaritalStatusRequest;
use App\Http\Resources\V1\MaritalStatus\MaritalStatusResource;
use App\Models\MaritalStatus;
use App\Services\Interfaces\GeneralSettings\MaritalStatusInterface;
use Exception;

class MaritalStatusController extends Controller
{
    public function __construct(private MaritalStatusInterface $martialStatusInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maritalStatuses = $this->martialStatusInterface->getAllMaritalStatus();
        return MaritalStatusResource::collection($maritalStatuses);
    }
}

