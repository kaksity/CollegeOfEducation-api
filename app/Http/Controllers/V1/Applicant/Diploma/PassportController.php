<?php

namespace App\Http\Controllers\V1\Applicant\Diploma;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\Passport\PassportRequest;
use App\Http\Resources\V1\Applicant\PassportResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PassportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $passport = Auth::user()->dipPassport()->first();
        return new PassportResource($passport);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PassportRequest $request)
    {
        try
        {
            //uniqid()                  
            $extention = $request->file->getClientOriginalExtension();      
            $fileNameToStore = time().uniqid().'.'.$extention;
            
            $path = $request->file->storeAs('public/passports', $fileNameToStore);

            $passport = Auth::user()->dipPassport()->first();
            
            if($passport == null){
                Auth::user()->dipPassport()->create([
                    'file_path' => $fileNameToStore
                ]);
            }
            else{
                $passport->file_path = $fileNameToStore;
                $passport->save();
            }
            
            $data['message'] = 'Applicant passport was uploaded successfully';
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
