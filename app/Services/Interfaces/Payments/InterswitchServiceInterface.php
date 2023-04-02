<?php

namespace App\Services\Interfaces\Payments;

interface InterswitchServiceInterface
{
    public function getInterswitchConfigurations();
    public function verifyTransaction($options);
}
