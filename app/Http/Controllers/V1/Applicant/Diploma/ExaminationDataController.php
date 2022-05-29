<?php

namespace App\Http\Controllers\V1\Applicant\Diploma;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\ExaminationData\ExaminationDataRequest;
use App\Http\Resources\V1\Applicant\ExaminationDataResource;
use Illuminate\Http\Request;
use App\Models\{ DipExaminationData };
use Exception;
use Illuminate\Support\Facades\Auth;

class ExaminationDataController extends Controller
{
    public function __construct(DipExaminationData $dipExaminationData)
    {
        $this->dipExaminationData = $dipExaminationData;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExaminationDataRequest $request)
    {
        $examinationData = Auth::user()->dipExaminationData()->latest()->paginate($request->per_page);
        return ExaminationDataResource::collection($examinationData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExaminationDataRequest $request)
    {
        try
        {
            Auth::user()->dipExaminationData()->create($request->all());
            $data['message'] = 'Applicant Examination data was added successfully';
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $dipExaminationData = $this->dipExaminationData->find($id);

            if($dipExaminationData == null)
            {
                throw new Exception('Applicant Examination data does not exist', 404);
            }
            $dipExaminationData->delete();
            $data['message'] = 'Applicant Examination data was created successfully';
            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
}
