<?php

namespace App\Http\Controllers\V1\Student\Nce;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Student\ExtraCurricularActivityData\ExtraCurricularActivityDataRequest;
use App\Http\Resources\V1\Student\ExtraCurricularActivityDataResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExtraCurricularActivityDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExtraCurricularActivityDataRequest $request)
    {
        $perPage = $request->per_page ?? 10;
        $extraCurricularActivities = Auth::user()->dipExtraCurricularActivityData()->latest()->paginate($perPage);
        return ExtraCurricularActivityDataResource::collection($extraCurricularActivities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExtraCurricularActivityDataRequest $request)
    {
        try
        {
            Auth::user()->dipExtraCurricularActivityData()->create($request->all());
            $data['message'] = 'Student extra-curricular activity data was added successfully';
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
            $extraCurricularActivity = Auth::user()->dipExtraCurricularActivityData()->find($id);
            
            if($extraCurricularActivity == null)
            {
                throw new Exception('Student extra-curricular activity does not exist',404);
            }

            $extraCurricularActivity->delete();

            $data['message'] = 'Student extra-curricular activity data was deleted successfully';
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
