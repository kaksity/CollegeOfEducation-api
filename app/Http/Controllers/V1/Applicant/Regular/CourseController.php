<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Course\CourseRequest;
use App\Http\Resources\V1\Course\CourseResource;
use Illuminate\Http\Request;

use App\Models\{Course};
use Exception;

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
    public function index(Request $request)
    {
        $courseGroup = $request->course_group ?? null;
        $courses = $this->course->when($courseGroup, function($model, $courseGroup) {
            $model->where('course_group_id', $courseGroup);
        })->latest()->get();
        return CourseResource::collection($courses);
    }
}
