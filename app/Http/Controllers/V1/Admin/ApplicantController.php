<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Applicant\ApplicantRequest;
use App\Http\Resources\V1\Admin\ApplicantDetailResource;
use App\Http\Resources\V1\Admin\ApplicantListResource;
use Illuminate\Http\Request;
use App\Models\{User, DipPersonalData, DipApplicationStatus, DipCourseData};
use Exception;

class ApplicantController extends Controller
{
    public function __construct(User $user, DipPersonalData $dipPersonalData, DipApplicationStatus $dipApplicationStatus, DipCourseData $dipCourseData)
    {
        $this->user = $user;
        $this->dipPersonalData = $dipPersonalData;
        $this->dipApplicationStatus = $dipApplicationStatus;
        $this->dipCourseData = $dipCourseData;
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
        $applicants = $this->dipApplicationStatus->where('status', $status)->latest()->paginate($perPage);
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

            $applicant = $this->dipApplicationStatus->where('user_id', $id)->first();
            
            if($applicant == null){
                throw new Exception('Applicant record does not exist', 404);
            }

            if($request->status == 'admitted'){
                $this->dipCourseData->where('user_id', $id)->update([
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
