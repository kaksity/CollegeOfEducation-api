<?php

namespace App\Http\Controllers\V1\Student\Diploma;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Student\EducationalBackgroundData\EducationalBackgroundDataRequest;
use App\Http\Resources\V1\Student\EducationalBackgroundDataResource;
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
        $StudentEducationalBackground = Auth::user()->dipEducationalBackground()->latest()->paginate($request->per_page);
        return EducationalBackgroundDataResource::collection($StudentEducationalBackground);
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
            $StudentEducationalBackground = Auth::user()->dipEducationalBackground();
            $StudentEducationalBackground->create($request->all());
            $data['message'] = 'Student educational background data was created successfully';
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
            $StudentEducationalBackground = Auth::user()->dipEducationalBackground()->find($id);

            if($StudentEducationalBackground == null)
            {
                throw new Exception("Student educational background data does exist",404);
            }

            $StudentEducationalBackground->delete();

            $data['message']= 'Student educational background data was deleted successfully';
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
