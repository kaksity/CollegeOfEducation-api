<?php

namespace App\Services\Interfaces\Bursary;

interface AdmissionPaymentServiceInterface
{
    public function getAllSetAdmissionPayments();
    public function getSetAdmissionPaymentById($setAdmissionPaymentId);
    public function getSetAdmissionPaymentByCourseGroup($courseGroupId);
    public function createNewSetAdmissionPayments(array $data);
    public function updateSetAdmissionPayment($setAdmissionPayment);
    public function deleteSetAdmissionPayment($setAdmissionPayment);
}
