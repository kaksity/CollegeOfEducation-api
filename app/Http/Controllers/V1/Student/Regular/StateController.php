<?php

namespace App\Http\Controllers\V1\Student\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\State\StateRequest;
use App\Http\Resources\V1\State\StateResource;
use Exception;
use Illuminate\Http\Request;
use App\Services\Interfaces\GeneralSettings\StateServiceInterface;

class StateController extends Controller
{
    public function __construct(private StateServiceInterface $stateServiceInterface)
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = $this->stateServiceInterface->getAllStates();
        return StateResource::collection($states);
    }
}
