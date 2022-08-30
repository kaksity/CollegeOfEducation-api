<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AcademicSession\NceAcademicSessionRequest;
use App\Http\Resources\V1\AcademicSession\NceAcademicSessionResource;
use Illuminate\Http\Request;
use App\Models\NceAcademicSession;
use Exception;

class AcademicSessionController extends Controller
{
    public function __construct(NceAcademicSession $nceAcademicSession)
    {
        $this->nceAcademicSession = $nceAcademicSession;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nceAcademicSessions = $this->nceAcademicSession->latest()->get();
        return NceAcademicSessionResource::collection($nceAcademicSessions);
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
            $nceAcademicSession = $this->nceAcademicSession->where([
                'course_group_id' => $request->course_group_id,
                'start_year' => $request->start_year,
                'end_year' => $request->end_year
            ])->first();
            if($nceAcademicSession != null)
            {
                throw new Exception('NCE Academic Session has been already been set', 400);
            }

            $this->nceAcademicSession->create([
                'start_year' => $request->start_year,
                'end_year' => $request->end_year
            ]);
            $data['message'] = 'NCE Academic Session was created successfully';

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
            $nceAcademicSession = $this->nceAcademicSession->find($id);

            if($nceAcademicSession == null)
            {
                throw new Exception('NCE Academic Session does not exist', 404);
            }

            $nceAcademicSession->delete();
            $data['message'] = 'NCE Academic Session was deleted successfully';

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
