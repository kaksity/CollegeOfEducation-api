<?php

namespace App\Http\Controllers\V1\Student\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Student\RegisterSubjectCourse\RegisterSubjectCourseRequest;
use App\Http\Resources\V1\Student\Nce\RegisteredCourseSubjectResource;
use Exception;
use Illuminate\Http\Request;
use App\Models\{NceRegisteredCourseSubject, CourseSubject, NceAcademicSession, NceCourseData};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterCourseSubjectController extends Controller
{
    public function __construct(NceRegisteredCourseSubject $NceRegisteredCourseSubject, CourseSubject $courseSubject, NceCourseData $NceCourseData, NceAcademicSession $nceAcademicSession)
    {
        $this->RegisteredCourseSubject = $NceRegisteredCourseSubject;
        $this->courseSubject = $courseSubject;
        $this->CourseData = $NceCourseData;
        $this->academicSession = $nceAcademicSession;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courseData = Auth::user()->nceCourseData()->first();

        $currentSession = $this->academicSession->getCurrentSession($courseData->course_group_id);
        
        $registeredCourseSubjects = $this->RegisteredCourseSubject->where([
            'user_id' => Auth::user()->id,
            'session_id' => $currentSession->id,
        ])->latest()->get();

        return RegisteredCourseSubjectResource::collection($registeredCourseSubjects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterSubjectCourseRequest $request)
    {
        try
        {
            $courseData = Auth::user()->nceCourseData()->first();

            $courseSubject = $this->courseSubject->find($request->course_subject_id);
            
            if($courseSubject == null)
            {
                throw new Exception('Course Subject does not exist', 404);
            }

            $currentSession = $this->academicSession->getCurrentSession($courseData->course_group_id);

            $this->RegisteredCourseSubject->create([
                'user_id' => Auth::user()->id,
                'course_subject_id' => $request->course_subject_id,
                'session_id' => $currentSession->id
            ]);

            $data['message'] = 'Course Subject was registered successfully';

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
            $registeredCourseSubject = $this->RegisteredCourseSubject->find($id);
            
            if($registeredCourseSubject == null)
            {
                throw new Exception('Course Subject does not exist', 404);
            }

            $registeredCourseSubject->delete();

            $data['message'] = 'Course Subject was registered successfully';

            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }

    public function autoFillCourses()
    {
        try
        {
            
            
            $courseData = $this->CourseData->where('user_id', Auth::user()->id)->first();
            $courseSubjects = $this->courseSubject->where('course_id', $courseData->admitted_course_id)->orderBy('semester', 'ASC')->get();
            $currentSession = $this->academicSession->getCurrentSession($courseData->course_group_id);

            DB::beginTransaction();
            foreach ($courseSubjects as $courseSubject) {
                $this->RegisteredCourseSubject->create([
                    'user_id' => Auth::user()->id,
                    'course_subject_id' => $courseSubject->id,
                    'session_id' => $currentSession->id
                ]);
            }
            DB::commit();
            $data['message'] = 'Course Subject was registered successfully';

            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            DB::rollBack();
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
}
