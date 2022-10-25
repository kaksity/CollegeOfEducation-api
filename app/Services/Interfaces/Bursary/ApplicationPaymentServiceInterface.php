<?php

namespace App\Services\Interfaces\Bursary;

interface ApplicationPaymentServiceInterface
{
    public function getAllSetApplicationPayments();
    public function getSetApplicationPaymentById($setApplicationPaymentId);
    public function getSetApplicationPaymentByCourseGroup($courseGroupId);
    public function createNewSetApplicationPayments(array $data);
    public function updateSetApplicationPayment($setApplicationPayment);
    public function deleteSetApplicationPayment($setApplicationPayment);

    public function getAllProcessedApplicationPayments($perPage);
}
