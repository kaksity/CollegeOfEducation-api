<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MaritalStatus\MaritalStatusRequest;
use App\Http\Resources\V1\MaritalStatus\MaritalStatusResource;
use App\Models\MaritalStatus;
use Exception;
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
        $data = [

            'title' => 'Welcome to ItSolutionStuff.com',

            'date' => date('m/d/Y')

        ];

          

        $pdf = PDF::loadView('submit-application', $data);

        $fileName = time().uniqid().'.pdf';

        $fileNameToStore = 'public/pdfs/'.$fileName;

        Storage::put($fileNameToStore, $pdf->output());
        
        return [
            'path' => env('APP_URL').'/storage/pdfs/'.$fileName
        ];
        // return $pdf->stream('student-application.pdf');
    }
}
