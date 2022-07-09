<?php

namespace App\Http\Controllers\V1\Applicant\Nce;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\EmploymentData\EmploymentDataRequest;
use App\Http\Resources\V1\Applicant\EmploymentDataResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmploymentDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EmploymentDataRequest $request)
    {
        $employmentData = Auth::user()->dipEmploymentData()->latest()->paginate($request->per_page);
        return EmploymentDataResource::collection($employmentData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmploymentDataRequest $request)
    {
        try
        {
            Auth::user()->dipEmploymentData()->create($request->all());
            $data['message'] = 'Applicant employment data was created successfully';
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
            $employmentData = Auth::user()->dipEmploymentData()->find($id);
            
            if($employmentData == null)
            {
                throw new Exception('Applicant employment data does not exist', 404);
            }

            $employmentData->delete();

            $data['message'] = 'Applicant employment data was deleted successfully';
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
