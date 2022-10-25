<?php

namespace App\Services\Interfaces\Students;

interface StudentServiceInterface
{
    public function getStudentByEmailAddress($emailAddress);
    public function getStudentByIDNumber($idNumber);
    public function createReturningStudent(array $data);
}
