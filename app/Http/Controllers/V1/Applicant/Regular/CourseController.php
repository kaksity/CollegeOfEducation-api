<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Course\CourseRequest;
use App\Http\Resources\V1\Course\CourseResource;
use Illuminate\Http\Request;

use App\Models\{Course};
use App\Services\Interfaces\GeneralSettings\CourseServiceInterface;
use Exception;

class CourseController extends Controller
{
    public function __construct(private CourseServiceInterface $courseServiceInterface)
    {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courseGroupId = $request->course_group ?? null;
        
        $courses = $this->courseServiceInterface->getAllCourses($courseGroupId);
        return CourseResource::collection($courses);
    }
}
