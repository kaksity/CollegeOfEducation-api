<?php

namespace App\Services\Interfaces;

interface CourseServiceInterface
{
    public function getAllCourses($courseGroupId);
    public function getCourseById($courseId);
    public function createNewCourse(array $data);
    public function updateCourse($course);
    public function deleteCourse($course);
}
