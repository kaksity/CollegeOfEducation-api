<?php

namespace App\Services\Implementations\GeneralSettings;

use App\Models\Course;
use App\Services\Interfaces\GeneralSettings\CourseServiceInterface;

class CourseServiceImplementation implements CourseServiceInterface
{
    public function getAllCourses($courseGroupId)
    {
        return Course::when($courseGroupId, function($model, $courseGroupId) {
            $model->where('course_group_id', $courseGroupId);
        })->latest()->get();
    }
    public function getCourseById($courseId)
    {
        return Course::where([
            'id' => $courseId
        ])->first();
    }
    public function createNewCourse(array $data)
    {
        return Course::create($data);
    }
    public function updateCourse($course)
    {
        $course->save();
    }

    public function deleteCourse($course)
    {
        $course->delete();
    }

}
