<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Applicant\Nce\ApplicationStatusResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applicationStatus = Auth::user()->nceApplicationStatus()->first();
        return new ApplicationStatusResource($applicationStatus);
    }
    public function store()
    {
        try
        {
            $applicationStatus = Auth::user()->nceApplicationStatus()->first();
            if($applicationStatus->status != 'applying'){
                throw new Exception('Applicant has already been '.$applicationStatus->status, 400);
            }
            $applicationStatus->admission_number = generateRandomString().generateRandomNumber();
            $applicationStatus->status = 'applied';
            $applicationStatus->save();
            $data['message'] = 'Application to the Institution was successfully done';
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
