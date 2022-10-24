<?php

namespace App\Services\Interfaces;

interface StateServiceInterface {
    public function getAllStates();

    public function getStateById($stateId);

    public function createNewState(array $data);

    public function updateState($state);

    public function deleteState($state);
}
