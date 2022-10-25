<?php

namespace App\Services\Interfaces\Students;

interface StudentServiceInterface
{
    public function getStudentByEmailAddress($emailAddress);
    public function getStudentByIDNumber($idNumber);
    public function getStudentById($studentId);
    public function createReturningStudent(array $data);
    public function createNewStudent(array $data);
    public function searchStudentByEmailAddressOrIdNumber($emailAddressOrIdNumber);
    public function getAllAdmittedStudents();
    public function getStudentByTrackingNumber($trackingNumber);
    public function uploadNewStudent($student);
}
