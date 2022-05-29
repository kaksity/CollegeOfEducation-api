<?php

namespace App\Http\Controllers\V1\Applicant\Diploma;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\HeldResponsibilityData\HeldResponsibilityDataRequest;
use App\Http\Resources\V1\Applicant\HeldResponsibilityDataResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HeldReponsibilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HeldResponsibilityDataRequest $request)
    {
        $perPage = $request->per_page ?? 10;
        
        $heldResponsibilities = Auth::user()->dipHeldResponsibilityData()->latest()->paginate($perPage);
        return HeldResponsibilityDataResource::collection($heldResponsibilities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HeldResponsibilityDataRequest $request)
    {
        try
        {
            Auth::user()->dipHeldResponsibilityData()->create($request->all());
            $data['message'] = 'Applicant held responsiblity data was added successfully';
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $heldResponsibility = Auth::user()->dipHeldResponsibilityData()->find($id);
            
            if($heldResponsibility == null)
            {
                throw new Exception('Applicant held Responsibility does not exist',404);
            }

            $heldResponsibility->delete();

            $data['message'] = 'Applicant held responsiblity data was deleted successfully';
            return successParser($data,201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code);
        }
    }
}
