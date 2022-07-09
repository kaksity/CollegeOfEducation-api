<?php

namespace App\Http\Controllers\V1\Student\Nce;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ExaminationCategory\ExaminationCategoryRequest;
use App\Http\Resources\V1\ExaminationCategory\ExaminationCategoryResource;
use App\Models\ExaminationCategory;
use Exception;
use Illuminate\Http\Request;

class ExaminationCategoryController extends Controller
{
    public function __construct(ExaminationCategory $examinationCategory)
    {
        $this->examinationCategory = $examinationCategory;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExaminationCategoryRequest $request)
    {
        $examinationCategories = $this->examinationCategory->latest()->paginate($request->per_page);
        return ExaminationCategoryResource::collection($examinationCategories);
    }
}
