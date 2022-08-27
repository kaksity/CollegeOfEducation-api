<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CourseSubject\CourseSubjectRequest;
use App\Http\Resources\V1\CourseSubject\CourseSubjectResource;
use Exception;
use Illuminate\Http\Request;
use App\Models\{CourseSubject, Course};

class CourseSubjectController extends Controller
{
    public function __construct(CourseSubject $courseSubject, Course $course)
    {
        $this->courseSubject = $courseSubject;
        $this->course = $course;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CourseSubjectRequest $request)
    {
        $course = $request->course_id;

        $courseSubjects = $this->courseSubject->when($course, function($model, $course) {
            $model->where('course_id', $course);
        })->latest()->get();
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
            $course = $this->course->find($request->course_id);

            if($course == null)
            {
                throw new Exception('Course does not exit', 404);
            }
            
            $this->courseSubject->create([
                'course_code' => $request->course_code,
                'course_title' => $request->course_title,
                'course_unit' => $request->course_unit,
                'semester' => $request->semester,
                'course_id' => $request->course_id
            ]);

            $data['message'] = 'Course Subject was added successfully';
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
            $courseSubject = $this->courseSubject->find($id);

            if($courseSubject == null)
            {
                throw new Exception('Course Subject does not exit', 404);
            }
            $courseSubject->delete();

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
