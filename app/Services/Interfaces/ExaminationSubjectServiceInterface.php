<?php

namespace App\Services\Interfaces;

interface ExaminationSubjectServiceInterface
{
    public function getAllExaminationSubjects($examinationCategoryId, $perPage);
    public function getExaminationSubjectById($examinationSubjectId);
    public function createNewExaminationSubject(array $data);
    public function updateExaminationSubject($examinationSubject);
    public function deleteExaminationSubject($examinationSubject);
}
