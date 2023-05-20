<?php

namespace App\Http\Controllers\V1\Student\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MaritalStatus\MaritalStatusRequest;
use App\Http\Resources\V1\Applicant\Nce\ApplicantDetailResource;
use App\Http\Resources\V1\MaritalStatus\MaritalStatusResource;
use App\Models\MaritalStatus;
use App\Models\NceAcademicSession;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\NceRegisteredCourseSubject;
use PDF;

class PDFController extends Controller
{
    public function __construct(NceRegisteredCourseSubject $nceRegisteredCourseSubject, NceAcademicSession $academicSession)
    {
        $this->nceRegisteredCourseSubject = $nceRegisteredCourseSubject;
        $this->academicSession = $academicSession;
    }
    
    public function generateCourseRegisteration()
    {
        $student = Auth::user();
        $personalData = $student->ncePersonalData;
        $contactData = $student->nceContactData;
        $passport = $student->ncePassport;
        $courseData = Auth::user()->nceCourseData()->first();

        $currentSession = $this->academicSession->getCurrentSession($courseData->course_group_id);

        $registerSemesterCourses = $this->nceRegisteredCourseSubject->with(['courseSubject'])->where([
            'user_id' => $student->id,
            'session_id' => $currentSession->id
        ])->get();

        $registerSemesterCourses = $registerSemesterCourses->pluck('courseSubject');
        
        $firstSemesterCourses = [];
        $secondSemesterCourses = [];

        foreach ($registerSemesterCourses as $registeredCourse) {
            if ($registeredCourse->semester == 'first')
            {
                array_push($firstSemesterCourses,$registeredCourse);
            }
            else {
                array_push($secondSemesterCourses,$registeredCourse);
            }
        }
        $courseGroup = $courseData->courseGroup;
        $admittedCourse = $courseData->NceCourseDataAdmittedCourse;

        $data = [
            'personalData' => $personalData,
            'contactData' => $contactData,
            'passport' => $passport,
            'firstSemesterCourses' => $firstSemesterCourses,
            'secondSemesterCourses' => $secondSemesterCourses,
            'student' => Auth::user(),
            'currentSession' => $currentSession,
            'admittedCourse' => $admittedCourse,
            'courseGroup' => $courseGroup,
            'courseData' => $courseData
        ];

        $pdf = PDF::setPaper('a4', 'portrait')->loadView('pdfs.student.course-registration', $data);

        $fileName = time().uniqid().'.pdf';

        $fileNameToStore = 'public/pdfs/'.$fileName;
        Storage::put($fileNameToStore, $pdf->output());
        
        return [
            'path' => env('APP_URL').'/storage/pdfs/'.$fileName
        ];
    }
}
