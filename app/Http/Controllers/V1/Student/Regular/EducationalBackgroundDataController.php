<?php

namespace App\Http\Controllers\V1\Student\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Student\EducationalBackgroundData\EducationalBackgroundDataRequest;
use App\Http\Resources\V1\Student\Nce\EducationalBackgroundDataResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Certificate};
use App\Services\Interfaces\GeneralSettings\CertificateServiceInterface;
use App\Services\Interfaces\Students\EducationalBackgroundDataServiceInterface;

class EducationalBackgroundDataController extends Controller
{
    public function __construct(
        private EducationalBackgroundDataServiceInterface $educationalBackgroundDataServiceInterface,
        private CertificateServiceInterface $certificateServiceInterface
    )
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EducationalBackgroundDataRequest $request)
    {
        $studentEducationalBackground = $this->educationalBackgroundDataServiceInterface
        ->getEducationalBackgroundByUserId(Auth::id(), $request->per_page);
        return EducationalBackgroundDataResource::collection($studentEducationalBackground);
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
            $certificate = $this->certificateServiceInterface->getCertificateById($request->certificate_id);
            if($certificate == null)
            {
                throw new Exception('Certificate record does not exist', 404);
            }
            
            $this->educationalBackgroundDataServiceInterface->createNewEducationalBackgroundData(
                array_merge($request->safe()->all(), [
                'user_id' => Auth::id()
            ]));

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
            $studentEducationalBackground = $this->educationalBackgroundDataServiceInterface
                                                    ->getEducationalBackgroundById($id);

            if($studentEducationalBackground == null)
            {
                throw new Exception("Student educational background data does exist",404);
            }

            $this->educationalBackgroundDataServiceInterface
                ->deleteEducationalBackgroundData($studentEducationalBackground);

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
