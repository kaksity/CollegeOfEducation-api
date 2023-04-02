<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AcademicSession\NceAcademicSessionRequest;
use App\Http\Resources\V1\AcademicSession\NceAcademicSessionResource;
use Illuminate\Http\Request;
use App\Services\Interfaces\GeneralSettings\AcademicSessionServiceInterface;
use Exception;

class AcademicSessionController extends Controller
{
    public function __construct(private AcademicSessionServiceInterface $academicSessionServiceInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NceAcademicSessionRequest $request)
    {
        $courseGroupId = $request->course_group_id ?? null;
        $academicSessions = [];

        if ($courseGroupId == null)
        {
            $academicSessions = $this->academicSessionServiceInterface->getAllAcademicSession();
        }
        else
        {
            $academicSessions = $this->academicSessionServiceInterface
                                    ->getAllAcademicSessionByCourseGroup($courseGroupId);
        }
        return NceAcademicSessionResource::collection($academicSessions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NceAcademicSessionRequest $request)
    {
        try
        {
            $doesAcademicSessionExists = $this->academicSessionServiceInterface
                                                ->checkIfAcademicSessionExists($request->safe()->all());
            
            if($doesAcademicSessionExists == true)
            {
                throw new Exception('Academic Session has been already been set', 400);
            }
            
            $this->academicSessionServiceInterface->createNewAcademicSession($request->safe()->all());
            $data['message'] = 'Academic Session was created successfully';

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
            $nceAcademicSession = $this->academicSessionServiceInterface->getAcademicSessionById($id);

            if($nceAcademicSession == null)
            {
                throw new Exception('Academic Session does not exist', 404);
            }

            $this->academicSessionServiceInterface->deleteAcademicSession($nceAcademicSession);
            $data['message'] = 'Academic Session was deleted successfully';

            return successParser($data, 200);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
}
