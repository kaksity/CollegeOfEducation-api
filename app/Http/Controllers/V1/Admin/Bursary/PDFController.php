<?php

namespace App\Http\Controllers\V1\Admin\Bursary;

use App\Http\Controllers\Controller;
use App\Models\CourseRegisterationCard;
use App\Models\NceAcademicSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;
class PDFController extends Controller
{
    public function __construct(CourseRegisterationCard $courseRegistrationCard, NceAcademicSession $academicSession)
    {
        $this->courseRegistrationCard = $courseRegistrationCard;
        $this->academicSession = $academicSession;
    }
    public function generateCourseRegistrationPinPDF(Request $request)
    {
        $currentSession = $this->academicSession->getCurrentSession($request->course_group_id);

        $courseRegistrationCards = $this->courseRegistrationCard->with(['academicSession', 'courseGroup'])->where([
            'academic_session_id' => $currentSession->id,
            'course_group_id' => $request->course_group_id
        ])->latest()->get();
        
        $courseRegistrationCards = $courseRegistrationCards->map(function($card) use ($currentSession){
            $courseGroup = $card->courseGroup;
            
            return [
                'academic_session' => "{$currentSession->start_year}/{$currentSession->end_year}",
                'course' => $courseGroup->name,
                'pin' => $card->pin,
                'serial_number' => $card->serial_number
            ];
        });
        $data = [
            'currentSession' => $currentSession,
            'cards' => $courseRegistrationCards
        ];

        $pdf = PDF::setPaper('a4', 'portrait')->loadView('pdfs.admin.bursary.course-registration-pins', $data);

        $fileName = time().uniqid().'.pdf';

        $fileNameToStore = 'public/pdfs/'.$fileName;

        Storage::put($fileNameToStore, $pdf->output());
        
        return [
            'path' => env('APP_URL').'/storage/pdfs/'.$fileName
        ];
    }
}
