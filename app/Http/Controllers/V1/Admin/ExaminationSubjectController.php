<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ExaminationSubject\ExaminationSubjectRequest;
use App\Http\Resources\V1\ExaminationSubject\ExaminationSubjectResource;
use App\Models\ExaminationSubject;
use Exception;
use Illuminate\Http\Request;

class ExaminationSubjectController extends Controller
{
    public function __construct(ExaminationSubject $examinationSubject)
    {
        $this->examinationSubject = $examinationSubject;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExaminationSubjectRequest $request)
    {
        $examinationCategoryId = $request->examination_category_id;
        $examinationSubjects = $this->examinationSubject->when($examinationCategoryId, function($model, $examinationCategoryId) {
            $model->where('examination_category_id', $examinationCategoryId);
        })->orderBy('subject','ASC')->paginate($request->per_page);
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
            $this->examinationSubject->create($request->all());
            $data['message'] = 'Examination Subject record was created successfully';
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
            $examinationSubject = $this->examinationSubject->find($id);
            if($examinationSubject == null)
            {
                throw new Exception('Examination subject record does not exist', 404);
            }
         
            $examinationSubject->examination_category_id = $request->examination_category_id;
            $examinationSubject->subject = $request->subject;
            $examinationSubject->save();

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
            $examinationSubject = $this->examinationSubject->find($id);
            if($examinationSubject == null)
            {
                throw new Exception('Examination subject record does not exist', 404);
            }
            
            $examinationSubject->delete();

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
