<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\ExaminationData\ExaminationCenterDataRequest;
use App\Http\Resources\V1\Applicant\Nce\ExaminationCenterDataResource;
use Illuminate\Http\Request;
use App\Models\{ NceExaminationCenterData };
use Exception;
use Illuminate\Support\Facades\Auth;

class ExaminationCenterDataController extends Controller
{
    public function __construct(NceExaminationCenterData $NceExaminationCenterData)
    {
        $this->NceExaminationCenterData = $NceExaminationCenterData;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examinationCenterData = $this->NceExaminationCenterData->where([
            'user_id' => Auth::id()
        ])->first();
        return new ExaminationCenterDataResource($examinationCenterData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExaminationCenterDataRequest $request)
    {
        try
        {
            $examinationCenterData = $this->NceExaminationCenterData->where([
                'user_id' => Auth::id()
            ])->first();
            $examinationCenterData->update([
                'center_number' => $request->center_number,
                'date_of_examination' => $request->date_of_examination,
                'examination_number' => $request->examination_number,
                'overall_result' => $request->overall_result
            ]);

            $data['message'] = 'Applicant Examination center data was updated successfully';
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
