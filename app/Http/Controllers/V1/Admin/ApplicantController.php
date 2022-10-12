<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Applicant\ApplicantRequest;
use App\Http\Resources\V1\Admin\ApplicantDetailResource;
use App\Http\Resources\V1\Admin\ApplicantListResource;
use Illuminate\Http\Request;
use App\Models\{NceAcademicSession, User, NcePersonalData, NceApplicationStatus, NceCourseData};
use Exception;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    public function __construct(User $user, NcePersonalData $ncePersonalData, NceApplicationStatus $nceApplicationStatus, NceCourseData $nceCourseData, NceAcademicSession $nceAcademicSession)
    {
        $this->user = $user;
        $this->ncePersonalData = $ncePersonalData;
        $this->nceApplicationStatus = $nceApplicationStatus;
        $this->nceCourseData = $nceCourseData;
        $this->nceAcademicSession = $nceAcademicSession;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ApplicantRequest $request)
    {
        $perPage = $request->per_page;
        $status = $request->status;
        $courseGroup = $request->course_group_id ?? null;

        $currentSession = $this->nceAcademicSession->getCurrentSession($courseGroup);
        
        if($currentSession == null)
        {
            throw new Exception('Current Academic Session for this course group has not been set', 400);
        }
        
        $applicants = $this->nceCourseData->whereHas('user.nceApplicationStatus', fn($model) => $model->where([
            'status' => $status,
            'academic_session_id' => $currentSession->id,
            'is_new_applicant' => true,
        ]))->when($courseGroup, function($model, $courseGroup){
            $model->where([
                'course_group_id' => $courseGroup,
            ]);
        })->latest()->paginate($perPage);
        return ApplicantListResource::collection($applicants);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $applicant = $this->user->find($id);
            
            if($applicant == null){
                throw new Exception('Applicant record does not exist', 404);
            }

            return new ApplicantDetailResource($applicant);
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
    public function update(ApplicantRequest $request, $id)
    {
        try
        {
            if($request->status == 'admitted' && $request->admitted_course_id == null){
                throw new Exception('Admitted Course is required if admitted', 400);
            }

            $applicant = $this->nceApplicationStatus->where('user_id', $id)->first();
            
            if($applicant == null){
                throw new Exception('Applicant record does not exist', 404);
            }

            if($request->status == 'admitted'){
                $this->nceCourseData->where('user_id', $id)->update([
                    'admitted_course_id' => $request->admitted_course_id
                ]);
            }
            $this->nceCourseData->where('user_id', $id)->update([
                'year_group' => $request->year_group
            ]);

            $applicant->status = $request->status;
            $applicant->save();
            $data['message'] = 'Applicant Status has been updated successfully';
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
        //
    }
}
