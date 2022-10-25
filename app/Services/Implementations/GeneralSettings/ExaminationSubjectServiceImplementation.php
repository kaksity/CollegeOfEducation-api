<?php

namespace App\Services\Implementations\GeneralSettings;

use App\Models\ExaminationSubject;
use App\Services\Interfaces\GeneralSettings\ExaminationSubjectServiceInterface;

class ExaminationSubjectServiceImplementation implements ExaminationSubjectServiceInterface
{
    public function getAllExaminationSubjects($examinationCategoryId, $perPage)
    {
        return ExaminationSubject::when($examinationCategoryId, function ($model, $examinationCategoryId) {
            $model->where('examination_category_id', $examinationCategoryId);
        })->orderBy('subject','ASC')->paginate($perPage);
    }

    public function getExaminationSubjectById($examinationSubjectId)
    {
        return ExaminationSubject::where([
            'id' => $examinationSubjectId
        ])->first();
    }

    public function createNewExaminationSubject(array $data)
    {
        return ExaminationSubject::create($data);
    }

    public function updateExaminationSubject($examinationSubject)
    {
        $examinationSubject->save();
    }

    public function deleteExaminationSubject($examinationSubject)
    {
        $examinationSubject->delete();
    }

}
