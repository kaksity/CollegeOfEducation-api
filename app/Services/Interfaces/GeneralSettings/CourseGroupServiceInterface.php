<?php

namespace App\Services\Interfaces\GeneralSettings;

interface CourseGroupServiceInterface
{
    public function getAllCourseGroups();

    public function createNewCourseGroup(array $data);

    public function getCourseGroupById($courseGroupId);
    
    public function getCourseGroupByName($courseGroupName);

    public function updateCourseGroup($courseGroup): void;

    public function deleteCourseGroup($courseGroup): void;
}
