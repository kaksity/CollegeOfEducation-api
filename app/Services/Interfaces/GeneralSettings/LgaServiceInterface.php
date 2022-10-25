<?php

namespace App\Services\Interfaces\GeneralSettings;

interface LgaServiceInterface
{
    public function getAllLgas($stateId);

    public function createNewLga(array $data);

    public function getLgaById($lgaId);

    public function updateLga($lga): void;

    public function deleteLga($lga): void;
}
