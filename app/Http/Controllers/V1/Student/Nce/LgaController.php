<?php

namespace App\Http\Controllers\V1\Student\Nce;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Lga\LgaResource;
use App\Http\Requests\V1\Lga\LgaRequest;
use App\Models\{Lga, State};
use Exception;



class LgaController extends Controller
{
    public function __construct(Lga $lga, State $state)
    {
        $this->lga = $lga;
        $this->state = $state;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LgaRequest $request)
    {
        $lgas = $this->lga->where('state_id',$request->state_id)->orderBy('name','ASC')->get();
        return LgaResource::collection($lgas);
    }
}
