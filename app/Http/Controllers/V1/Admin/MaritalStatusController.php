<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MaritalStatus\MaritalStatusRequest;
use App\Http\Resources\V1\MaritalStatus\MaritalStatusResource;
use App\Models\MaritalStatus;
use Exception;

class MaritalStatusController extends Controller
{
    public function __construct(MaritalStatus $maritalStatus)
    {
        $this->maritalStatus = $maritalStatus;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maritalStatuses = $this->maritalStatus->latest()->get();
        return MaritalStatusResource::collection($maritalStatuses);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaritalStatusRequest $request)
    {
        try
        {
            $this->maritalStatus->create($request->all());
            $data['message'] = 'Marital Status record was created successfully';
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MaritalStatusRequest $request, $id)
    {
        try
        {
            $maritalStatus = $this->maritalStatus->find($id);
            
            if($maritalStatus == null)
            {
                throw new Exception('Marital Status record does not exist',404);
            }

            $maritalStatus->name = $request->name;
            $maritalStatus->save();

            $data['message'] = 'Marital Status record was updated successfully';
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
            $maritalStatus = $this->maritalStatus->find($id);
            
            if($maritalStatus == null)
            {
                throw new Exception('Marital Status record does not exist',404);
            }

            $maritalStatus->delete();

            $data['message'] = 'Marital Status record was deleted successfully';
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
