<?php
namespace App\Services\Implementations;

use App\Models\CourseSubject;
use App\Services\Interfaces\CourseSubjectServiceInterface;

class CourseSubjectServiceImplementation implements CourseSubjectServiceInterface
{
    public function getAllCourseSubjects($courseGroupId, $perPage)
    {
        return CourseSubject::when($courseGroupId, function ($model, $course) {
            $model->where('course_id', $course);
        })->latest()->paginate($perPage);
    }
    public function getCourseSubjectById($courseSubjectId)
    {
        return CourseSubject::where([
            'id' => $courseSubjectId
        ])->first();
    }
    public function createNewCourseSubject(array $data)
    {
        return CourseSubject::create($data);
    }

    public function updateCourseSubject($courseSubject)
    {
        $courseSubject->save();
    }

    public function deleteCourseSubject($courseSubject)
    {
        $courseSubject->delete();
    }

}
