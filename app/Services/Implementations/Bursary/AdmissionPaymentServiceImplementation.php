<?php

namespace App\Services\Implementations\Bursary;

use App\Models\AdmissionSetPayment;
use App\Services\Interfaces\Bursary\AdmissionPaymentServiceInterface;

class AdmissionPaymentServiceImplementation implements AdmissionPaymentServiceInterface
{
    public function getAllSetAdmissionPayments()
    {
        return AdmissionSetPayment::latest()->get();
    }

    public function getSetAdmissionPaymentById($setAdmissionPaymentId)
    {
        return AdmissionSetPayment::where([
            'id' => $setAdmissionPaymentId
        ])->first();
    }

    public function getSetAdmissionPaymentByCourseGroup($courseGroupId)
    {
        return AdmissionSetPayment::where([
            'course_group_id' => $courseGroupId
        ])->first();
    }

    public function createNewSetAdmissionPayments(array $data)
    {
        return AdmissionSetPayment::create($data);
    }

    public function updateSetAdmissionPayment($setAdmissionPayment)
    {
        $setAdmissionPayment->save();
    }

    public function deleteSetAdmissionPayment($setAdmissionPayment)
    {
        $setAdmissionPayment->delete();
    }

}
