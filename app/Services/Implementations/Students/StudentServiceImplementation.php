<?php

namespace App\Services\Implementations\Students;

use App\Models\NceApplicationStatus;
use App\Models\NceContactData;
use App\Models\NceCourseData;
use App\Models\NceExaminationCenterData;
use App\Models\NcePassport;
use App\Models\NcePersonalData;
use App\Models\User;
use App\Services\Interfaces\GeneralSettings\AcademicSessionServiceInterface;
use App\Services\Interfaces\Students\StudentServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentServiceImplementation implements StudentServiceInterface
{
    public function __construct(private AcademicSessionServiceInterface $academicSessionServiceInterface)
    {
        
    }
    public function getStudentByEmailAddress($emailAddress)
    {
        return User::where([
            'email_address' => $emailAddress,
            'role' => 'student'
        ])->first();
    }

    public function getStudentByIDNumber($idNumber)
    {
        return User::where([
            'id_number' => $idNumber,
            'role' => 'student'
        ])->first();
    }

    public function getStudentById($studentId)
    {
        return User::where([
            'id' => $studentId,
            'role' => 'student'
        ])->first();
    }

    public function createReturningStudent(array $data)
    {
        DB::beginTransaction();
            try
            {
                $user = User::create([
                    'email_address' => $data['email_address'],
                    'id_number' => $data['id_number'],
                    'password' => Hash::make($data['password']),
                ]);
                NcePersonalData::create([
                    'user_id' => $user->id,
                    'surname' => $data['surname'],
                    'other_names' => $data['other_names'],
                    'state_id' => $data['state_id']
                ]);
                NceContactData::create([
                    'user_id' => $user->id,
                    'email_address' => $data['email_address']
                ]);
                NceCourseData::create([
                    'user_id' => $user->id,
                    'year_group' => $data['year_group'],
                    'course_group_id' => $data['course_group_id'],
                    'admitted_course_id' => $data['course_id'],
                ]);

                $currentSession = $this->academicSessionServiceInterface
                                        ->getCurrentSessionByCourseGroupId($data['course_group_id']);

                NceApplicationStatus::create([
                    'user_id' => $user->id,
                    'status' => 'admitted',
                    'academic_session_id' => $currentSession->id,
                    'is_new_applicant' => false,
                ]);
                NcePassport::create([
                    'user_id' => $user->id
                ]);
                NceExaminationCenterData::create([
                    'user_id' => $user->id
                ]);
                DB::commit();
            }
            catch(Exception $ex)
            {
                DB::rollBack();
                throw $ex;
            }
    }

    public function getAllAdmittedStudents($perPage = 100)
    {
        return User::where('role', 'student')
            ->with([
                'ncePersonalData',
                'nceCourseData'
            ])
            ->whereHas('nceApplicationStatus', fn($model) => $model->where([
                'status' => 'admitted',
            ]))->latest()->paginate($perPage);
    }

    public function searchStudentByEmailAddressOrIdNumber($emailAddressOrIdNumber, $perPage = 100)
    {
        return User::where('role', 'student')
            ->with([
                'ncePersonalData',
                'nceCourseData'
            ])
            ->where('id_number', 'like', $emailAddressOrIdNumber.'%')
            ->orWhere('email_address', 'like', $emailAddressOrIdNumber.'%')
            ->whereHas('nceApplicationStatus', fn($model) => $model->where([
                'status' => 'admitted',
            ]))->latest()->paginate($perPage);
    }
    
    public function uploadNewStudent($student)
    {
        $student->save();
    }

    public function getStudentByTrackingNumber($trackingNumber)
    {
        return NceApplicationStatus::where([
            'admission_number' => $trackingNumber,
            'status' => 'admitted'
        ])->first();
    }
}
