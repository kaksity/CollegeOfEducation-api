<?php

namespace App\Http\Controllers\V1\Student\Regular;

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
        $semester = $request->semester;
        $courseSubjects = $this->courseSubject->when($course, function($model, $course) {
            $model->where('course_id', $course);
        })->when($semester, function($model, $semester) {
            $model->where('semester', $semester);
        })->latest()->get();
        return CourseSubjectResource::collection($courseSubjects);
    }
}
