<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

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
        $stateId = $request->state_id;
        
        $lgas = $this->lga->when($stateId, function($model, $stateId) {
            $model->where('state_id',$stateId);
        })->orderBy('name','ASC')->get();
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
            $state = $this->state->find($request->state_id);
            
            if($state == null)
            {
                throw new Exception('State record does not exist',404);
            }

            $this->lga->create($request->all());
            $data['message'] = 'Lga record was created successfully';
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
    public function update(LgaRequest $request, $id)
    {
        try
        {
            $lga = $this->lga->find($id);
            
            if($lga == null)
            {
                throw new Exception('Lga record does not exist',404);
            }

            $lga->name = $request->name;
            $lga->save();

            $data['message'] = 'Lga record was updated successfully';
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $lga = $this->lga->find($id);
            
            if($lga == null)
            {
                throw new Exception('Lga record does not exist',404);
            }

            $lga->delete();

            $data['message'] = 'Lga record was deleted successfully';
            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code);
        }
    }
}
