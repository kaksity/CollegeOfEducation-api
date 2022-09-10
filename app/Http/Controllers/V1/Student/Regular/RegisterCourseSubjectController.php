<?php

namespace App\Http\Controllers\V1\Student\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Student\RegisterSubjectCourse\RegisterSubjectCourseRequest;
use App\Http\Resources\V1\Student\Nce\RegisteredCourseSubjectResource;
use Exception;
use Illuminate\Http\Request;
use App\Models\{NceRegisteredCourseSubject, CourseSubject, NceCourseData};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterCourseSubjectController extends Controller
{
    public function __construct(NceRegisteredCourseSubject $NceRegisteredCourseSubject, CourseSubject $courseSubject, NceCourseData $NceCourseData)
    {
        $this->NceRegisteredCourseSubject = $NceRegisteredCourseSubject;
        $this->courseSubject = $courseSubject;
        $this->NceCourseData = $NceCourseData;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $registeredCourseSubjects = $this->NceRegisteredCourseSubject->where('user_id', Auth::user()->id)->latest()->get();
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
            $courseSubject = $this->courseSubject->find($request->course_subject_id);
            
            if($courseSubject == null)
            {
                throw new Exception('Course Subject does not exist', 404);
            }

            $this->NceRegisteredCourseSubject->create([
                'user_id' => Auth::user()->id,
                'course_subject_id' => $request->course_subject_id
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
            $registeredCourseSubject = $this->NceRegisteredCourseSubject->find($id);
            
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
            
            
            $NceCourseData = $this->NceCourseData->where('user_id', Auth::user()->id)->first();
            $courseSubjects = $this->courseSubject->where('course_id', $NceCourseData->admitted_course_id)->orderBy('semester', 'ASC')->get();
            DB::beginTransaction();
            foreach ($courseSubjects as $courseSubject) {
                $this->NceRegisteredCourseSubject->create([
                    'user_id' => Auth::user()->id,
                    'course_subject_id' => $courseSubject->id,
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
