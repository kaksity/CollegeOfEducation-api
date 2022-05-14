<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Certificate\CertificateRequest;
use App\Http\Resources\V1\Certificate\CertificateResource;
use Illuminate\Http\Request;
use App\Models\Certificate;
use Exception;

class CertificateController extends Controller
{
    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $certificates = $this->certificate->latest()->get();
        return CertificateResource::collection($certificates);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CertificateRequest $request)
    {
        try
        {
            $this->certificate->create($request->all());
            return successParser([
                'message' => 'Certificate record was created successfully'
            ],201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $certificate = $this->certificate->find($id);
        
            if($certificate == null){
                throw new Exception('Certificate does not exist',404);
            }
            $certificate->name = $request->name;
            $certificate->save();

            return successParser([
                'message' => 'Certificate record was updated successfully'
            ]);
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
            $certificate = $this->certificate->find($id);
        
            if($certificate == null){
                throw new Exception('Certificate does not exist',404);
            }

            $certificate->delete();

            return successParser([
                'message' => 'Certificate record was deleted successfully'
            ]);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code); 
        }
    }
}
