<?php

namespace App\Services\Implementations\GeneralSettings;

use App\Models\CourseGroup;
use App\Services\Interfaces\GeneralSettings\CourseGroupServiceInterface;

class CourseGroupServiceImplementation implements CourseGroupServiceInterface
{
    public function getAllCourseGroups()
    {
        return CourseGroup::latest()->get();
    }

    public function createNewCourseGroup(array $data)
    {
        return CourseGroup::create($data);
    }

    public function getCourseGroupById($courseGroupId)
    {
        return CourseGroup::where([
            'id' => $courseGroupId
        ])->first();
    }

    public function getCourseGroupByName($courseGroupName)
    {
        return CourseGroup::where([
            'name' => $courseGroupName
        ])->first();
    }

    public function updateCourseGroup($courseGroup): void
    {
        $courseGroup->update();
    }

    public function deleteCourseGroup($courseGroup): void
    {
        $courseGroup->delete();
    }
}
