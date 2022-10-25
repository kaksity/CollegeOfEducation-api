<?php

namespace App\Services\Implementations\Bursary;

use App\Models\ApplicantSetPayment;
use App\Models\NceApplicationPayment;
use App\Services\Interfaces\Bursary\ApplicationPaymentServiceInterface;

class ApplicationPaymentServiceImplementation implements ApplicationPaymentServiceInterface
{
    public function getAllSetApplicationPayments()
    {
        return ApplicantSetPayment::latest()->get();
    }

    public function getSetApplicationPaymentById($setApplicationPaymentId)
    {
        return ApplicantSetPayment::where([
            'id' => $setApplicationPaymentId
        ])->first();
    }
    
    public function getSetApplicationPaymentByCourseGroup($courseGroupId)
    {
        return ApplicantSetPayment::where([
            'course_group_id' => $courseGroupId
        ])->first();
    }

    public function createNewSetApplicationPayments(array $data)
    {
        return ApplicantSetPayment::create($data);
    }

    public function updateSetApplicationPayment($setApplicationPayment)
    {
        $setApplicationPayment->save();
    }

    public function deleteSetApplicationPayment($setApplicationPayment)
    {
        $setApplicationPayment->delete();
    }

    public function getAllProcessedApplicationPayments($perPage)
    {
        return NceApplicationPayment::latest()->paginate($perPage);
    }
}
