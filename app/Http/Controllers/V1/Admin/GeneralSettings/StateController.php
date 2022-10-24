<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\State\StateRequest;
use App\Http\Resources\V1\State\StateResource;
use Exception;
use App\Services\Interfaces\StateServiceInterface;

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

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateRequest $request)
    {
        try
        {
            $state = $this->stateServiceInterface->createNewState($request->safe()->all());
            $data['message'] = 'State record was created successfully';
            $data['data'] = new StateResource($state);
            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $state = $this->stateServiceInterface->getStateById($id);
        return new StateResource($state);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StateRequest $request, $id)
    {
        try
        {
            $state = $this->stateServiceInterface->getStateById($id);
            if($state == null)
            {
                throw new Exception("State record does not exist",404);
            }

            $state->name = $request->name;
            $this->stateServiceInterface->updateState($state);
            $data['message'] = 'State record was updated successfully';
            return successParser($data);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $state = $this->stateServiceInterface->getStateById($id);
            if($state == null)
            {
                throw new Exception("State record does not exist",404);
            }

            $this->stateServiceInterface->deleteState($state);
            $data['message'] = 'State record was deleted successfully';
            return successParser($data);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code);
        }
    }
}
