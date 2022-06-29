<?php

namespace App\Http\Controllers\V1\Student\Diploma;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Student\ApplicationStatusResource;
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
        $applicationStatus = Auth::user()->dipApplicationStatus()->first();
        return new ApplicationStatusResource($applicationStatus);
    }
    public function store()
    {
        try
        {
            $applicationStatus = Auth::user()->dipApplicationStatus()->first();
            if($applicationStatus->status != 'applying'){
                throw new Exception('Student has already been '.$applicationStatus->status, 400);
            }
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