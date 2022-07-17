<?php

namespace App\Http\Controllers\V1\Student\Nce;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Student\ExaminationData\ExaminationDataRequest;
use App\Http\Resources\V1\Student\Nce\ExaminationDataResource;
use Illuminate\Http\Request;
use App\Models\{ NceExaminationData };
use Exception;
use Illuminate\Support\Facades\Auth;

class ExaminationDataController extends Controller
{
    public function __construct(NceExaminationData $NceExaminationData)
    {
        $this->NceExaminationData = $NceExaminationData;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ExaminationDataRequest $request)
    {
        $examinationData = Auth::user()->nceExaminationData()->latest()->paginate($request->per_page);
        return ExaminationDataResource::collection($examinationData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExaminationDataRequest $request)
    {
        try
        {
            Auth::user()->nceExaminationData()->create($request->all());
            $data['message'] = 'Student Examination data was added successfully';
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $NceExaminationData = $this->NceExaminationData->find($id);

            if($NceExaminationData == null)
            {
                throw new Exception('Student Examination data does not exist', 404);
            }
            $NceExaminationData->delete();
            $data['message'] = 'Student Examination data was created successfully';
            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
}
