<?php

namespace App\Services\Interfaces\Payments;

interface RemitaServiceInterface
{
    public function initiatePayment($options);
    public function getRemitaConfigurations();
    public function generateRemitaHash($options, $payment = true);
    public function verifyPayment($options);
}
