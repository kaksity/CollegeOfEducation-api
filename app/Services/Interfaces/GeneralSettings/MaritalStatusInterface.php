<?php

namespace App\Services\Interfaces\GeneralSettings;

interface MaritalStatusInterface {
    public function getAllMaritalStatus();

    public function createNewMaritalStatus(array $data): void;

    public function getMaritalStatusById($maritalStatusId);

    public function updateMaritalStatus($maritalStatus): void;

    public function deleteMaritalStatus($maritalStatus): void;
}
