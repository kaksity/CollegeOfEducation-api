<?php

namespace App\Http\Controllers\V1\Student\Regular;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Student\Nce\ApplicationStatusResource;
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
    public function store(Request $request)
    {
        $request->validate([
            'id_number' => ['required', 'string']
        ]);
        try
        {
            $applicationStatus = Auth::user()->nceApplicationStatus()->first();
            
            if($applicationStatus->id_number != null)
            {
                throw new Exception('Student ID Number has already been set', 400);
            }
            
            $applicationStatus->id_number = $request->id_number;
            $applicationStatus->save();
            $data['message'] = 'ID Number was set successfully';
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
