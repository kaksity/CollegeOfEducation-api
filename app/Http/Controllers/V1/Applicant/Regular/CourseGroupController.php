<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CourseGroup\CourseGroupResource;
use App\Services\Interfaces\GeneralSettings\CourseGroupServiceInterface;

class CourseGroupController extends Controller
{
    public function __construct(private CourseGroupServiceInterface $courseGroupServiceInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courseGroups = $this->courseGroupServiceInterface->getAllCourseGroups();
        return CourseGroupResource::collection($courseGroups);
    }
}
