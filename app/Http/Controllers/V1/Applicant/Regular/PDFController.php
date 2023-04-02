<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MaritalStatus\MaritalStatusRequest;
use App\Http\Resources\V1\Applicant\Nce\ApplicantDetailResource;
use App\Http\Resources\V1\MaritalStatus\MaritalStatusResource;
use App\Models\MaritalStatus;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class PDFController extends Controller
{
    public function __construct(MaritalStatus $maritalStatus)
    {
        $this->maritalStatus = $maritalStatus;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function submitApplication()
    {

        $applicant = Auth::user();
        $personalData = $applicant->ncePersonalData()->with(['maritalStatus', 'state', 'lga'])->first();
        $passport = $applicant->ncePassport;
        $personalData = $applicant->ncePersonalData;
        $contactData = $applicant->nceContactData;
        $employmentData = $applicant->nceEmploymentData;
        $examinationData = $applicant->nceExaminationData()->with(['examinationCategory', 'examinationSubject'])->get();
        $educationalBackgroundData = $applicant->nceEducationalBackground()->with(['certificate'])->get();
        $extraCurricularActivityData = $applicant->nceExtraCurricularActivityData;
        $heldResponsibilityData = $applicant->nceHeldResponsibilityData;
        $applicationStatus = $applicant->nceApplicationStatus()->with(['nceSession'])->first();   
        $courseData =  $applicant->nceCourseData()->with(['NceCourseDataFirstChoice', 'NceCourseDataSecondChoice', 'NceCourseDataThirdChoice'])->first();
        $examinationCenterData = $applicant->nceExaminationCenterData;
        $requiredDocumentData = $applicant->nceRequiredDocumentData()->with(['requiredDocument'])->get();
        
        $data = [
           'personalData' => $personalData,
           'contactData' => $contactData,
           'passport' => $passport,
           'educationalBackgroundData' => $educationalBackgroundData,
           'examinationCenterData' => $examinationCenterData,
           'examinationData' => $examinationData,
           'courseData' => $courseData,
           'employmentData' => $employmentData,
           'requiredDocumentData' => $requiredDocumentData,
           'extraCurricularActivityData' => $extraCurricularActivityData,
           'applicationStatus' => $applicationStatus,
           'heldResponsibilityData' => $heldResponsibilityData
        ];
        
        $pdf = PDF::setPaper('a4', 'landscape')->loadView('pdfs.applicant.submit-application', $data);

        $fileName = time().uniqid().'.pdf';

        $fileNameToStore = 'public/pdfs/'.$fileName;

        Storage::put($fileNameToStore, $pdf->output());
        
        return [
            'path' => env('APP_URL').'/storage/pdfs/'.$fileName
        ];
        // return $pdf->stream('student-application.pdf');
    }
    public function generateAdmissionLetter()
    {
        $applicant = Auth::user();
        $personalData = $applicant->ncePersonalData()->with(['maritalStatus', 'state', 'lga'])->first();
        $courseData =  $applicant->nceCourseData()->with(['courseGroup', 'NceCourseDataAdmittedCourse'])->first();
        // $dateOfAdmission = str_replace('-', '/', substr($applicationStatus->updated_atformat('Y-m-d'), 0, 10))
        $dateOfAdmission = $courseData->updated_at->format('d/m/Y');
        $applicationStatus = $applicant->nceApplicationStatus()->with(['nceSession'])->first();
        $data = [
            'personalData' => $personalData,
            'courseData' => $courseData,
            'applicationStatus' => $applicationStatus,
            'dateOfAdmission' => $dateOfAdmission,
        ];

        $pdf = PDF::setPaper('a4', 'portrait')->loadView('pdfs.applicant.admission-letter', $data);

        $fileName = time().uniqid().'.pdf';

        $fileNameToStore = 'public/pdfs/'.$fileName;

        Storage::put($fileNameToStore, $pdf->output());
        
        return [
            'path' => env('APP_URL').'/storage/pdfs/'.$fileName
        ];
    }
}
