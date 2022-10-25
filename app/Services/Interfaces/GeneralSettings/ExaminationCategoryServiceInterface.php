<?php

namespace App\Services\Interfaces\GeneralSettings;

interface ExaminationCategoryServiceInterface
{
    public function getAllExaminationCategories($perPage);
    public function getExaminationCategoryById($examinationCategoryId);
    public function createNewExaminationCategory(array $data);
    public function updateExaminationCategory($examinationCategory);
    public function deleteExaminationCategory($examinationCategory);
}
