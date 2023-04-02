<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MaritalStatus\MaritalStatusRequest;
use App\Http\Resources\V1\MaritalStatus\MaritalStatusResource;
use App\Services\Interfaces\GeneralSettings\MaritalStatusInterface;
use Exception;

class MaritalStatusController extends Controller
{
    public function __construct(private MaritalStatusInterface $maritalStatusInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maritalStatuses = $this->maritalStatusInterface->getAllMaritalStatus();
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
            $this->maritalStatusInterface->createNewMaritalStatus($request->safe()->all());
            $data['message'] = 'Marital Status record was created successfully';
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
            $maritalStatus = $this->maritalStatusInterface->getMaritalStatusById($id);
            
            if ($maritalStatus == null)
            {
                throw new Exception('Marital Status record does not exist',404);
            }

            $maritalStatus->name = $request->name;
            
            $this->maritalStatusInterface->updateMaritalStatus($maritalStatus);

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
            $maritalStatus = $this->maritalStatusInterface->getMaritalStatusById($id);
            
            if($maritalStatus == null)
            {
                throw new Exception('Marital Status record does not exist',404);
            }

            $this->maritalStatusInterface->deleteMaritalStatus($maritalStatus);

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
