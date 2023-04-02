<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\CourseData\CourseDataRequest;
use App\Http\Resources\V1\Applicant\Nce\CourseDataResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Course};
use App\Services\Interfaces\GeneralSettings\CourseServiceInterface;
use App\Services\Interfaces\Students\CourseDataServiceInterface;

class CourseDataController extends Controller
{

    public function __construct(private CourseDataServiceInterface $courseDataServiceInterface, private CourseServiceInterface $courseServiceInterface)
    {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courseData = $this->courseDataServiceInterface->getCourseDataByUserId(Auth::user()->id);
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
            $courseData = $this->courseDataServiceInterface->getCourseDataByUserId(Auth::user()->id);

            if ($courseData->id != $id)
            {
                throw new Exception('You can only update your data',400);
            }
            
            $firstChoiceCourse = $this->courseServiceInterface->getCourseById($request->first_choice_course_id); 

            if ($firstChoiceCourse == null)
            {
                throw new Exception('First choice course does not exist', 400);
            }

            $secondChoiceCourse = $this->courseServiceInterface->getCourseById($request->second_choice_course_id);
            
            if ($secondChoiceCourse == null)
            {
                throw new Exception('Second choice course does not exist', 400);
            }

            $thirdChoiceCourse = $this->courseServiceInterface->getCourseById($request->third_choice_course_id);
            if ($thirdChoiceCourse == null)
            {
                throw new Exception('Third choice course does not exist', 400);
            }

            $courseData->first_choice_course_id = $request->first_choice_course_id;
            $courseData->second_choice_course_id = $request->second_choice_course_id;
            $courseData->third_choice_course_id = $request->third_choice_course_id;

            $this->courseDataServiceInterface->updateCourseData($courseData);

            $data['message'] = 'Applicant Course data was updated successfully';
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
