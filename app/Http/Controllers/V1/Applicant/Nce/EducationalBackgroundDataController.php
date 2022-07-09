<?php

namespace App\Http\Controllers\V1\Applicant\Nce;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\EducationalBackgroundData\EducationalBackgroundDataRequest;
use App\Http\Resources\V1\Applicant\EducationalBackgroundDataResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Certificate};
class EducationalBackgroundDataController extends Controller
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
    public function index(EducationalBackgroundDataRequest $request)
    {
        $applicantEducationalBackground = Auth::user()->dipEducationalBackground()->latest()->paginate($request->per_page);
        return EducationalBackgroundDataResource::collection($applicantEducationalBackground);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EducationalBackgroundDataRequest $request)
    {
        try
        {
            $certificate = $this->certificate->find($request->certificate_id);
            if($certificate == null)
            {
                throw new Exception('Certificate record does not exist', 404);
            }
            $applicantEducationalBackground = Auth::user()->dipEducationalBackground();
            $applicantEducationalBackground->create($request->all());
            $data['message'] = 'Applicant educational background data was created successfully';
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
            $applicantEducationalBackground = Auth::user()->dipEducationalBackground()->find($id);

            if($applicantEducationalBackground == null)
            {
                throw new Exception("Applicant educational background data does exist",404);
            }

            $applicantEducationalBackground->delete();

            $data['message']= 'Applicant educational background data was deleted successfully';
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
