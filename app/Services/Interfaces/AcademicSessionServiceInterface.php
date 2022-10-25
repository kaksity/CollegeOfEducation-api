<?php

namespace App\Services\Interfaces;

interface AcademicSessionServiceInterface
{
    public function createNewAcademicSession(array $data);
    public function getAllAcademicSession();
    public function checkIfAcademicSessionExists(array $data);
    public function getAllAcademicSessionByCourseGroup($courseGroupId);
    public function getAcademicSessionById($academicSessionId);
    public function updateAcademicSession($academicSession);
    public function deleteAcademicSession($academicSession);
}
