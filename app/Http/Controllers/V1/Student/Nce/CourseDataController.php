<?php

namespace App\Http\Controllers\V1\Student\Nce;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Student\CourseData\CourseDataRequest;
use App\Http\Resources\V1\Student\Nce\CourseDataResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Course};
class CourseDataController extends Controller
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
        // $courseData = Auth::user()->dipCourseData()->with(['dipCourseDataFirstChoice, dipCourseDataSecondChoice'])->first();
        $courseData = Auth::user()->dipCourseData->first();
        return new CourseDataResource($courseData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseDataRequest $request, $id)
    {
        try
        {
            $firstChoiceCourse = $this->course->find($request->first_choice_course_id); 
            if($firstChoiceCourse == null)
            {
                throw new Exception('First choice course does not exist');
            }

            $secondChoiceCourse = $this->course->find($request->second_choice_course_id);
            if($secondChoiceCourse == null)
            {
                throw new Exception('Second choice course does not exist');
            }

            $courseData = Auth::user()->dipCourseData()->first();
            
            if($courseData->id != $id)
            {
                throw new Exception('You can only update your data',400);
            }
            
            $courseData->first_choice_course_id = $request->first_choice_course_id;
            $courseData->second_choice_course_id = $request->second_choice_course_id;

            $courseData->save();

            $data['message'] = 'Student Course data was updated successfully';
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
