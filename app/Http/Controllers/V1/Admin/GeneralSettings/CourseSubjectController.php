<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CourseSubject\CourseSubjectRequest;
use App\Http\Resources\V1\CourseSubject\CourseSubjectResource;
use Exception;
use App\Services\Interfaces\CourseServiceInterface;
use App\Services\Interfaces\CourseSubjectServiceInterface;

class CourseSubjectController extends Controller
{
    public function __construct(
        private CourseSubjectServiceInterface $courseSubjectServiceInterface,
        private CourseServiceInterface $courseServiceInterface
    )
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CourseSubjectRequest $request)
    {
        $courseId = $request->course_id;
        $perPage = $request->per_page ?? 100;
        $courseSubjects = $this->courseSubjectServiceInterface->getAllCourseSubjects($courseId, $perPage);
        return CourseSubjectResource::collection($courseSubjects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseSubjectRequest $request)
    {
        try
        {
            $course = $this->courseServiceInterface->getCourseById($request->course_id);

            if ($course == null)
            {
                throw new Exception('Course does not exit', 404);
            }
            
            $courseSubject = $this->courseSubjectServiceInterface->createNewCourseSubject($request->safe()->all());
            $data['message'] = 'Course Subject was added successfully';
            $data['data'] = new CourseSubjectResource($courseSubject);
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
            $courseSubject = $this->courseSubjectServiceInterface->getCourseSubjectById($id);

            if($courseSubject == null)
            {
                throw new Exception('Course Subject does not exit', 404);
            }
            $this->courseSubjectServiceInterface->deleteCourseSubject($courseSubject);

            $data['message'] = 'Course Subject was deleted successfully';
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
