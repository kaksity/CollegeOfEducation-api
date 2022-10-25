<?php

namespace App\Services\Implementations\Bursary;

use App\Models\NceCoursePayment;
use App\Services\Interfaces\Bursary\CoursePaymentServiceInterface;

class CoursePaymentServiceImplementation implements CoursePaymentServiceInterface
{
    public function getAllSetCoursePayments($perPage)
    {
        return NceCoursePayment::with(['nceCourse'])->latest()->paginate($perPage);
    }

    public function checkIfCoursePaymentAlreadyExists(array $data)
    {
        $coursePayment = NceCoursePayment::where([
            'course_id' => $data['course_id'],
            'is_indigine' => $data['is_indigine'],
            'year_group' => $data['year_group']
        ])->first();

        return $coursePayment != null;
    }

    public function getSetCoursePaymentById($setCoursePaymentId)
    {
        return NceCoursePayment::where([
            'id' => $setCoursePaymentId
        ])->first();
    }
    
    public function getSetCoursePaymentByCourse($courseId)
    {
        return NceCoursePayment::where([
            'course_id' => $courseId
        ])->first();
    }

    public function getSetCoursePaymentByCourseGroup($courseGroupId)
    {
        return NceCoursePayment::where([
            'course_group_id' => $courseGroupId
        ])->first();
    }

    public function createNewSetCoursePayments(array $data)
    {
        return NceCoursePayment::create($data);
    }

    public function updateSetCoursePayment($setCoursePayment)
    {
        $setCoursePayment->save();
    }

    public function deleteSetCoursePayment($setCoursePayment)
    {
        $setCoursePayment->delete();
    }

    public function getAllProcessedRegisterationPayments($perPage)
    {
        return NceCoursePayment::with([
            'nceStudent.nceApplicationStatus',
            'nceSession',
            'nceCourse',
            'nceStudent'
        ])->latest()->paginate($perPage);
    }
}
