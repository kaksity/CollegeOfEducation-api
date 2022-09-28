<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExaminationCategoryRequest $request)
    {
        try
        {
            $examinationCategory = $this->examinationCategory->create($request->all());
            $data['message'] = 'Examination category record was created successfully';
            $data['data'] = new ExaminationCategoryResource($examinationCategory);
            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExaminationCategoryRequest $request, $id)
    {
        try
        {
            $examinationCategory = $this->examinationCategory->find($id);

            if($examinationCategory == null)
            {
                throw new Exception('Examination category record does not exist', 404);
            }
            $examinationCategory->category = $request->category;
            $examinationCategory->save();
            $data['message'] = 'Examination category record was updated successfully';
            return successParser($data);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $examinationCategory = $this->examinationCategory->find($id);

            if($examinationCategory == null)
            {
                throw new Exception('Examination category record does not exist', 404);
            }
            $examinationCategory->delete();
            $data['message'] = 'Examination category record was deleted successfully';
            return successParser($data);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
}
