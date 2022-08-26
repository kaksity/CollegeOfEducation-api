<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Course\CourseResource;
use App\Models\CourseGroup;
use Exception;
use Illuminate\Http\Request;

class CourseGroupController extends Controller
{
    public function __construct(CourseGroup $courseGroup)
    {
        $this->courseGroup = $courseGroup;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courseGroups = $this->courseGroup->orderBy('name', 'ASC')->get();
        return CourseResource::collection($courseGroups);
    }
}
