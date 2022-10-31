<?php

namespace App\Services\Interfaces\Students;

interface CourseDataServiceInterface
{
    public function getCourseDataByUserId($userId);
    public function updateCourseData($courseData);
}
