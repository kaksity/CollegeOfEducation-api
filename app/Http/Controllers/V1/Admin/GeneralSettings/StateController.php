<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

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
            $state = $this->state->create($request->safe()->all());
            $data['message'] = 'State record was created successully';
            $data['data'] = new StateResource($state);
            return successParser($data,201);
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
        $state = $this->state->find($id);
        // dd($state);
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
            $state = $this->state->find($id);
            if($state == null)
            {
                throw new Exception("State record does not exist",404);
            }

            $state->name = $request->name;
            $state->save();
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
            $state = $this->state->find($id);
            if($state == null)
            {
                throw new Exception("State record does not exist",404);
            }

            $state->delete();
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
