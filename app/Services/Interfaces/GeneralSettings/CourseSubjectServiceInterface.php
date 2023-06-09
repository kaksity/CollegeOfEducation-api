<?php

namespace App\Services\Interfaces\GeneralSettings;

interface CourseSubjectServiceInterface
{
    public function getAllCourseSubjects($courseGroupId, $perPage);
    public function getCourseSubjectById($courseSubjectId);
    public function createNewCourseSubject(array $data);
    public function updateCourseSubject($courseSubject);
    public function deleteCourseSubject($courseSubject);
}
