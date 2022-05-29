<?php

namespace App\Http\Controllers\V1\Applicant\Diploma;

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
        $examinationSubjects = $this->examinationSubject->where('examination_category_id', $request->examination_category_id)->orderBy('subject','ASC')->paginate($request->per_page);
        return ExaminationSubjectResource::collection($examinationSubjects);
    }
}
