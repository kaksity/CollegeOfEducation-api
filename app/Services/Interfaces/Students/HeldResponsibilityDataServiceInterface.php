<?php

namespace App\Services\Interfaces\Students;

interface HeldResponsibilityDataServiceInterface
{
    public function createNewHeldResponsibility(array $data);
    public function getHeldResponsibilityById($heldResponsibilityId);
    public function deleteHeldResponsibility($heldResponsibility);
    public function getHeldResponsibilityByUserId($userId, $perPage);
}
