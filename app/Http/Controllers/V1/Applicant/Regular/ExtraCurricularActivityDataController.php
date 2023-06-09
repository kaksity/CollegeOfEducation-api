<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\ExtraCurricularActivityData\ExtraCurricularActivityDataRequest;
use App\Http\Resources\V1\Applicant\Nce\ExtraCurricularActivityDataResource;
use App\Services\Interfaces\Students\ExtraCurricularDataServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExtraCurricularActivityDataController extends Controller
{
    public function __construct(private ExtraCurricularDataServiceInterface $extraCurricularDataServiceInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExtraCurricularActivityDataRequest $request)
    {
        $perPage = $request->per_page ?? 10;
        $extraCurricularActivities = $this->extraCurricularDataServiceInterface
                                            ->getExtraCurricularActivityByUserId(Auth::id(), $perPage);
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
            $this->extraCurricularDataServiceInterface
                ->createNewExtraCurricularActivity(array_merge($request->safe()->all(), [
                'user_id' => Auth::id()
            ]));
            $data['message'] = 'Applicant extra-curricular activity data was added successfully';
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
            $extraCurricularActivity = $this->extraCurricularDataServiceInterface->getExtraCurricularActivityById($id);
            
            if($extraCurricularActivity == null)
            {
                throw new Exception('Applicant extra-curricular activity does not exist',404);
            }

            $this->extraCurricularDataServiceInterface->deleteExtraCurricularActivity($extraCurricularActivity);

            $data['message'] = 'Applicant extra-curricular activity data was deleted successfully';
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
