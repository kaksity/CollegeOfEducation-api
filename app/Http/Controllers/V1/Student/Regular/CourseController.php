<?php

namespace App\Http\Controllers\V1\Student\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Course\CourseRequest;
use App\Http\Resources\V1\Course\CourseResource;
use Illuminate\Http\Request;

use App\Models\{Course};
use Exception;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function __construct(Course $course)
    {
        $this->course = $course;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courseData = Auth::user()->nceCourseData()->first();
        $courses = $this->course->with('courseGroup')->where('course_group_id', $courseData->course_group_id)->latest()->get();
        return CourseResource::collection($courses);
    }
}
