<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ExaminationSubject\ExaminationSubjectRequest;
use App\Http\Resources\V1\ExaminationSubject\ExaminationSubjectResource;
use App\Models\ExaminationSubject;
use App\Services\Interfaces\GeneralSettings\ExaminationSubjectServiceInterface;
use Exception;
use Illuminate\Http\Request;

class ExaminationSubjectController extends Controller
{
    public function __construct(private ExaminationSubjectServiceInterface $examinationSubjectServiceInterface)
    {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExaminationSubjectRequest $request)
    {
        $examinationCategoryId = $request->examination_category_id;
        $perPage = $request->per_page ?? 100;
        $examinationSubjects = $this->examinationSubjectServiceInterface
                                    ->getAllExaminationSubjects($examinationCategoryId, $perPage);
        return ExaminationSubjectResource::collection($examinationSubjects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExaminationSubjectRequest $request)
    {
        try
        {
            $examinationSubject = $this->examinationSubjectServiceInterface
                                        ->createNewExaminationSubject($request->safe()->all());
            $data['message'] = 'Examination Subject record was created successfully';
            $data['data'] = new ExaminationSubjectResource($examinationSubject);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExaminationSubjectRequest $request, $id)
    {
        try
        {
            $examinationSubject = $this->examinationSubjectServiceInterface->getExaminationSubjectById($id);
            if($examinationSubject == null)
            {
                throw new Exception('Examination subject record does not exist', 404);
            }
         
            $examinationSubject->examination_category_id = $request->examination_category_id;
            $examinationSubject->subject = $request->subject;
            $this->examinationSubjectServiceInterface->updateExaminationSubject($examinationSubject);

            $data['message'] = 'Examination Subject record was updated successfully';
            return successParser($data, 200);
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
            $examinationSubject = $this->examinationSubjectServiceInterface->getExaminationSubjectById($id);
            if($examinationSubject == null)
            {
                throw new Exception('Examination subject record does not exist', 404);
            }
            
            $this->examinationSubjectServiceInterface->deleteExaminationSubject($examinationSubject);

            $data['message'] = 'Examination Subject record was deleted successfully';
            return successParser($data, 200);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
}
