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
        // application_status = ApplicationStatusResource($this->user->nceApplicationStatus;
        $courseData =  $applicant->nceCourseData()->with(['NceCourseDataFirstChoice', 'NceCourseDataSecondChoice', 'NceCourseDataThirdChoice'])->first();
        $examinationCenterData = $applicant->nceExaminationCenterData;
        $requiredDocumentData = $applicant->nceRequiredDocumentData()->with(['requiredDocument'])->get();
        
        $data = [
           'personalData' => $personalData,
           'contactData' => $contactData,
           'educationalBackgroundData' => $educationalBackgroundData,
           'examinationCenterData' => $examinationCenterData,
           'examinationData' => $examinationData,
           'courseData' => $courseData,
           'employmentData' => $employmentData,
           'requiredDocumentData' => $requiredDocumentData,
           'extraCurricularActivityData' => $extraCurricularActivityData,
           'heldResponsibilityData' => $heldResponsibilityData
        ];
        
        $pdf = PDF::setPaper('a4', 'landscape')->loadView('submit-application', $data);

        $fileName = time().uniqid().'.pdf';

        $fileNameToStore = 'public/pdfs/'.$fileName;

        Storage::put($fileNameToStore, $pdf->output());
        
        return [
            'path' => env('APP_URL').'/storage/pdfs/'.$fileName
        ];
        // return $pdf->stream('student-application.pdf');
    }
}
