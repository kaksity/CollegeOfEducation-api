<?php

namespace App\Http\Controllers\V1\Student\Regular;

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
}
