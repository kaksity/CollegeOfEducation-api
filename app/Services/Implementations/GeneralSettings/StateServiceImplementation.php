<?php
namespace App\Services\Implementations\GeneralSettings;

use App\Models\State;
use App\Services\Interfaces\GeneralSettings\StateServiceInterface;

class StateServiceImplementation implements StateServiceInterface
{
    public function getAllStates()
    {
        return State::orderBy('name','ASC')->get();
    }

    public function getStateById($stateId)
    {
        return State::where([
            'id' => $stateId
        ])->first();
    }

    public function createNewState(array $data)
    {
        return State::create($data);
    }

    public function updateState($state)
    {
        $state->save();
    }

    public function deleteState($state)
    {
        $state->delete();
    }
}
