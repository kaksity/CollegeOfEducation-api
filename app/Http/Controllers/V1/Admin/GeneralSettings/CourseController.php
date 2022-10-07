<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

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
        $courseGroup = $request->course_group_id ?? null;
        $courses = $this->course->when($courseGroup, function($model, $courseGroup) {
            $model->where('course_group_id', $courseGroup);
        })->latest()->get();
        return CourseResource::collection($courses);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        try
        {
            $course = $this->course->create([
                'name' => $request->name,
                'course_group_id' => $request->course_group_id
            ]);
            $data['message'] = 'Course record was created successfully';
            $data['data'] = new CourseResource($course);
            return successParser($data,201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, $id)
    {
        try
        {
            $course = $this->course->find($id);
            
            if($course == null)
            {
                throw new Exception('Course record does not exist',404);
            }

            $course->name = $request->name;
            $course->save();

            $data['message'] = 'Course record was updated successfully';
            return successParser($data);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code);
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
            $course = $this->course->find($id);
            
            if($course == null)
            {
                throw new Exception('Course record does not exist',404);
            }

            $course->delete();

            $data['message'] = 'Course record was deleted successfully';
            return successParser($data);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code);
        }
    }
}
