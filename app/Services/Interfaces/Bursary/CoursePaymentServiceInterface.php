<?php

namespace App\Services\Interfaces\Bursary;

interface CoursePaymentServiceInterface
{
    public function getAllSetCoursePayments($perPage);
    public function getSetCoursePaymentById($setCoursePaymentId);
    public function getSetCoursePaymentByCourse($courseId);
    public function checkIfCoursePaymentAlreadyExists(array $data);
    public function getSetCoursePaymentByCourseGroup($courseGroupId);
    public function createNewSetCoursePayments(array $data);
    public function updateSetCoursePayment($setCoursePayment);
    public function deleteSetCoursePayment($setCoursePayment);

    public function getAllProcessedRegisterationPayments($perPage);
}
