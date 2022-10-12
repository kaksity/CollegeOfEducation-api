<?php
namespace App\Http\Controllers\V1\Admin\ICT;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\ICT\ReturningStudentRequest;
use App\Models\{NceAcademicSession, NceContactData, User, NcePersonalData, NceCourseData, NceApplicationStatus, NcePassport, NceExaminationCenterData};
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReturningStudentController extends Controller
{
    public function __construct(User $user, NcePersonalData $NcePersonalData, NcePassport $NcePassport,NceApplicationStatus $NceApplicationStatus,NceContactData $NceContactData, NceCourseData $NceCourseData, NceExaminationCenterData $NceExaminationCenterData, NceAcademicSession $nceAcademicSession)
    {
        $this->user = $user;
        $this->NcePersonalData = $NcePersonalData;
        $this->NceContactData = $NceContactData;
        $this->NceCourseData = $NceCourseData;
        $this->NceApplicationStatus = $NceApplicationStatus;
        $this->NcePassport = $NcePassport;
        $this->NceExaminationCenterData = $NceExaminationCenterData;
        $this->nceAcademicSession = $nceAcademicSession;
    }
    // public function index(UploadStudentRequest $request)
    // {
    //     try
    //     {
    //         $student = $this->nceApplicationStatus->where([
    //             'admission_number' => $request->application_tracking_number,
    //             'status' => 'admitted'
    //         ])->first();
    //         if($student == null)
    //         {
    //             throw new Exception('Student record does not exist', 404);
    //         }
    //         return new UploadStudentResource($student);
    //     }
    //     catch(Exception $ex)
    //     {
    //         $data['message'] = $ex->getMessage();
    //         $code = $ex->getCode();
    //         return errorParser($data, $code);
    //     }
    // }
    public function store(ReturningStudentRequest $request)
    {
        try
        {
            // Check if the email_address already exist
            $user = $this->user->where('email_address', $request->email_address)->first();
            if($user != null)
            {
                throw new Exception('Student Email has already been registered',400);
            }
            
            $user = $this->user->where('id_number', $request->id_number)->first();
            if($user != null)
            {
                throw new Exception('Student ID has already been registered',400);
            }

            $currentSession = $this->nceAcademicSession->getCurrentSession($request->course_group_id);
            if($currentSession == null)
            {
                throw new Exception('Current Session has not been set by the admin',400);
            }
            DB::beginTransaction();
            try
            {
                $user = $this->user->create([
                    'email_address' => $request->email_address,
                    'id_number' => $request->id_number,
                    'password' => Hash::make($request->password),
                ]);
                $this->NcePersonalData->create([
                    'user_id' => $user->id,
                    'surname' => $request->surname,
                    'other_names' => $request->other_names,
                    'state_id' => $request->state_id
                ]);
                $this->NceContactData->create([
                    'user_id' => $user->id,
                    'email_address' => $request->email_address
                ]);
                $this->NceCourseData->create([
                    'user_id' => $user->id,
                    'year_group' => $request->year_group,
                    'course_group_id' => $request->course_group_id,
                    'admitted_course_id' => $request->course_id,
                ]);

                $this->NceApplicationStatus->create([
                    'user_id' => $user->id,
                    'status' => 'admitted',
                    'academic_session_id' => $currentSession->id,
                    'is_new_applicant' => false,
                ]);
                $this->NcePassport->create([
                    'user_id' => $user->id
                ]);
                $this->NceExaminationCenterData->create([
                    'user_id' => $user->id
                ]);
                DB::commit();
                
                $data['message'] = 'Student account was created successfully';
                return successParser($data,201);

            }
            catch(Exception $ex)
            {
                DB::rollBack();
                $data['message'] = $ex->getMessage();
                $code = $ex->getCode();
                return errorParser($data,$code);
            }
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();

            return errorParser($data,$code);
        }
    }
    // public function update(UploadStudentRequest $request, $id)
    // {
    //     try
    //     {
    //         $student = $this->user->find($id);

    //         if($student == null)
    //         {
    //             throw new Exception('Student record does not exist', 404);
    //         }
            
    //         if($student->id_number != null || $student->id_number != '' )
    //         {
    //             throw new Exception('Student ID Number has already been set', 400);
    //         }

    //         $student->update([
    //             'id_number' => $request->id_number
    //         ]);
    //         $data['message'] = 'Student ID Number has been set successfully';
    //         return successParser($data);
    //     }
    //     catch(Exception $ex)
    //     {
    //         $data['message'] = $ex->getMessage();
    //         $code = $ex->getCode();
    //         return errorParser($data, $code);
    //     }
    // } 
}