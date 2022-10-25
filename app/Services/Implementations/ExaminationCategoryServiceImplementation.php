<?php

namespace App\Services\Implementations;

use App\Models\ExaminationCategory;
use App\Services\Interfaces\ExaminationCategoryServiceInterface;

class ExaminationCategoryServiceImplementation implements ExaminationCategoryServiceInterface
{
    public function getAllExaminationCategories($perPage)
    {
        return ExaminationCategory::latest()->paginate($perPage);
    }
    
    public function getExaminationCategoryById($examinationCategoryId)
    {
        return ExaminationCategory::where([
            'id' => $examinationCategoryId
        ])->first();
    }
    
    public function createNewExaminationCategory(array $data)
    {
        return ExaminationCategory::create($data);
    }
    
    public function updateExaminationCategory($examinationCategory)
    {
        $examinationCategory->save();
    }
    
    public function deleteExaminationCategory($examinationCategory)
    {
        $examinationCategory->delete();
    }
    
}
