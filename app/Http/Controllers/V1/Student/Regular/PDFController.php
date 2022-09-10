<?php

namespace App\Http\Controllers\V1\Student\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MaritalStatus\MaritalStatusRequest;
use App\Http\Resources\V1\Applicant\Nce\ApplicantDetailResource;
use App\Http\Resources\V1\MaritalStatus\MaritalStatusResource;
use App\Models\MaritalStatus;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\NceRegisteredCourseSubject;
use PDF;

class PDFController extends Controller
{
    public function __construct(NceRegisteredCourseSubject $nceRegisteredCourseSubject)
    {
        $this->nceRegisteredCourseSubject = $nceRegisteredCourseSubject;    
    }
    
    public function generateCourseRegisteration()
    {
        $applicant = Auth::user();
        $personalData = $applicant->ncePersonalData;
        $contactData = $applicant->nceContactData;
        // $firstSemesterCourses = $this->nceRegisteredCourseSubject->with(['courseSubject' => function($model) {
        //         $model->where('semester', 'first')->orderBy('course_code', 'ASC');
        //     }])->where('user_id', $applicant->id)->get();
        // $secondSemeterCourses = $this->nceRegisteredCourseSubject->with(['courseSubject' => function($model) {
        //     $model->where('semester', 'second')->orderBy('course_code', 'ASC');
        // }])->where('user_id', $applicant->id)->get();
        $registerSemesterCourses = $this->nceRegisteredCourseSubject->with(['courseSubject'])->where('user_id', $applicant->id)->get();
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

        $data = [
            'personalData' => $personalData,
           'contactData' => $contactData,
           'firstSemesterCourses' => $firstSemesterCourses,
            'secondSemesterCourses' => $secondSemesterCourses,
        ];

        $pdf = PDF::setPaper('a4', 'portrait')->loadView('course-registeration', $data);

        $fileName = time().uniqid().'.pdf';

        $fileNameToStore = 'public/pdfs/'.$fileName;

        Storage::put($fileNameToStore, $pdf->output());
        
        return [
            'path' => env('APP_URL').'/storage/pdfs/'.$fileName
        ];
    }
}
