<?php

namespace App\Services\Implementations\Students;

use App\Models\NceCourseData;
use App\Services\Interfaces\Students\CourseDataServiceInterface;

class CourseDataServiceImplementation implements CourseDataServiceInterface
{
    public function getCourseDataByUserId($userId)
    {
        return NceCourseData::where([
            'user_id' => $userId
        ])->first();
    }

    public function updateCourseData($courseData)
    {
        $courseData->save();
    }
}
