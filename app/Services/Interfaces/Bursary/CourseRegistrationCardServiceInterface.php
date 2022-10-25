<?php

namespace App\Services\Interfaces\Bursary;

interface CourseRegistrationCardServiceInterface
{
    public function getAllCourseRegistrationCard($perPage);

    public function createNewCourseRegistrationCards(array $data);

    public function getCourseRegistrationCardById($cardId);

    public function updateCourseRegistrationCard($courseRegistrationCard);
}
