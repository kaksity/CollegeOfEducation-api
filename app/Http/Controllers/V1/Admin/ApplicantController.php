<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Applicant\ApplicantRequest;
use App\Http\Resources\V1\Admin\ApplicantDetailResource;
use App\Http\Resources\V1\Admin\ApplicantListResource;
use Illuminate\Http\Request;
use App\Models\{User, NcePersonalData, NceApplicationStatus, NceCourseData};
use Exception;

class ApplicantController extends Controller
{
    public function __construct(User $user, NcePersonalData $NcePersonalData, NceApplicationStatus $NceApplicationStatus, NceCourseData $NceCourseData)
    {
        $this->user = $user;
        $this->NcePersonalData = $NcePersonalData;
        $this->NceApplicationStatus = $NceApplicationStatus;
        $this->NceCourseData = $NceCourseData;
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
        $applicants = $this->NceApplicationStatus->where('status', $status)->latest()->paginate($perPage);
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

            $applicant = $this->NceApplicationStatus->where('user_id', $id)->first();
            
            if($applicant == null){
                throw new Exception('Applicant record does not exist', 404);
            }

            if($request->status == 'admitted'){
                $this->NceCourseData->where('user_id', $id)->update([
                    'admitted_course_id' => $request->admitted_course_id
                ]);
            }
            
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
