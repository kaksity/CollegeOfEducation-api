<?php

namespace App\Http\Controllers\V1\Applicant\Diploma;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\State\StateRequest;
use App\Http\Resources\V1\State\StateResource;
use Exception;
use Illuminate\Http\Request;
use App\Models\State;
class StateController extends Controller
{
    public function __construct(State $state)
    {
        $this->state = $state;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = $this->state->orderBy('name','ASC')->get();
        return StateResource::collection($states);
    }

}
