<?php

namespace App\Services\Implementations;

use App\Models\NceAcademicSession;
use App\Services\Interfaces\AcademicSessionServiceInterface;

class AcademicSessionServiceImplementation implements AcademicSessionServiceInterface
{
    public function createNewAcademicSession(array $data)
    {
        return NceAcademicSession::create($data);
    }

    public function getAllAcademicSession()
    {
        return NceAcademicSession::latest()->get();
    }

    public function checkIfAcademicSessionExists(array $data)
    {
        $academicSession = NceAcademicSession::where([
            'course_group_id' => $data['course_group_id'],
            'start_year' => $data['start_year'],
            'end_year' => $data['end_year']
        ])->first();
        return $academicSession != null;
    }

    public function getAllAcademicSessionByCourseGroup($courseGroupId)
    {
        return NceAcademicSession::where([
            'course_group_id' => $courseGroupId
        ])->latest()->get();
    }

    public function getAcademicSessionById($academicSessionId)
    {
        return NceAcademicSession::where([
            'id' => $academicSessionId
        ])->first();
    }

    public function updateAcademicSession($academicSession)
    {
        $academicSession->save();
    }

    public function deleteAcademicSession($academicSession)
    {
        $academicSession->delete();
    }

}
