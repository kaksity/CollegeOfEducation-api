<?php

namespace App\Http\Controllers\V1\Student\Regular;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Lga\LgaResource;
use App\Http\Requests\V1\Lga\LgaRequest;
use App\Models\{Lga, State};
use App\Services\Interfaces\GeneralSettings\LgaServiceInterface;
use Exception;



class LgaController extends Controller
{
    public function __construct(private LgaServiceInterface $lgaServiceInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LgaRequest $request)
    {
        $lgas = $this->lgaServiceInterface->getAllLgas($request->state_id);
        return LgaResource::collection($lgas);
    }
}
