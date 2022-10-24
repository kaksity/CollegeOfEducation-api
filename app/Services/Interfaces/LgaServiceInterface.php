<?php

namespace App\Services\Interfaces;

interface LgaServiceInterface
{
    public function getAllLgas($stateId);

    public function createNewLga(array $data): void;

    public function getLgaById($lgaId);

    public function updateLga($lga): void;

    public function deleteLga($lga): void;
}
