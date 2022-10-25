<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Lga\LgaResource;
use App\Http\Requests\V1\Lga\LgaRequest;
use App\Services\Interfaces\LgaServiceInterface;
use App\Services\Interfaces\StateServiceInterface;
use Exception;



class LgaController extends Controller
{
    public function __construct(
        private LgaServiceInterface $lgaServiceInterface,
        private StateServiceInterface $stateServiceInterface
    )
    {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LgaRequest $request)
    {
        $stateId = $request->state_id ?? null;
        $lgas = $this->lgaServiceInterface->getAllLgas($stateId);
        return LgaResource::collection($lgas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LgaRequest $request)
    {
        try
        {
            $state = $this->stateServiceInterface->getStateById($request->state_id);
            
            if($state == null)
            {
                throw new Exception('State record does not exist',404);
            } 

            $lga = $this->lgaServiceInterface->createNewLga($request->safe()->all());
            $data['message'] = 'Lga record was created successfully';
            $data['data'] = new LgaResource($lga);
            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LgaRequest $request, $id)
    {
        try
        {
            $lga = $this->lgaServiceInterface->getLgaById($id);
            
            if($lga == null)
            {
                throw new Exception('Lga record does not exist', 404);
            }

            $lga->name = $request->name;
            $this->lgaServiceInterface->updateLga($lga);

            $data['message'] = 'Lga record was updated successfully';
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
            $lga = $this->lgaServiceInterface->getLgaById($id);
            
            if($lga == null)
            {
                throw new Exception('Lga record does not exist',404);
            }

            $this->lgaServiceInterface->deleteLga($lga);

            $data['message'] = 'Lga record was deleted successfully';
            return successParser($data);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
}
