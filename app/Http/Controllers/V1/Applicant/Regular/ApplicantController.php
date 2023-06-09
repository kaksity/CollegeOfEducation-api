<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Applicant\ApplicantRequest;
use App\Http\Resources\V1\Applicant\Nce\ApplicantDetailResource;
use App\Http\Resources\V1\Admin\ApplicantListResource;
use Illuminate\Http\Request;
use App\Models\{User, NcePersonalData, NceApplicationStatus, NceCourseData};
use Exception;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applicant = Auth::user();
        return new ApplicantDetailResource($applicant);
    }
}
