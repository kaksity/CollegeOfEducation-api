<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CourseGroup\CourseGroupRequest;
use App\Http\Resources\V1\Course\CourseResource;
use App\Http\Resources\V1\CourseGroup\CourseGroupResource;
use App\Services\Interfaces\GeneralSettings\CourseGroupServiceInterface;
use Exception;
use Illuminate\Http\Request;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseGroupRequest $request)
    {
        try
        {
            $courseGroup = $this->courseGroupServiceInterface->getCourseGroupByName($request->name);
            if($courseGroup != null)
            {
                throw new Exception('Course group record already exit',400);
            }

            $courseGroup = $this->courseGroupServiceInterface->createNewCourseGroup($request->safe()->all());

            $data['message'] = 'Course group record was created successfully';
            $data['data'] = new CourseGroupResource($courseGroup);
            return successParser($data);
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
            $courseGroup = $this->courseGroupServiceInterface->getCourseGroupById($id);
            
            if($courseGroup == null)
            {
                throw new Exception('Course group record does not exit',404);
            }

            $this->courseGroupServiceInterface->deleteCourseGroup($courseGroup);

            $data['message'] = 'Course group record was deleted successfully';
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
