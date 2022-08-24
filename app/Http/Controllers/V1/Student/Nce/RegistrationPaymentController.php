<?php

namespace App\Http\Controllers\V1\Student\Nce;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Student\NceRegistrationPayment\NceRegisterationPaymentRequest;
use App\Models\NceAcademicSession;
use App\Models\NceCoursePayment;
use App\Models\NceRegistrationPayment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationPaymentController extends Controller
{
    public function __construct( NceAcademicSession $nceAcademicSession, NceCoursePayment $nceCoursePayment, NceRegistrationPayment $nceRegistrationPayment)
    {
        $this->nceRegistrationPayment = $nceRegistrationPayment;
        $this->nceCoursePayment = $nceCoursePayment;
        $this->nceAcademicSession = $nceAcademicSession;
    }
    public function initiatePayment(NceRegisterationPaymentRequest $request)
    {
        try
        {
            if ($request->payment_gateway == 'interswitch')
            {

                $personalData = Auth::user()->ncePersonalData()->first();
                $contactData = Auth::user()->nceContactData()->first();                
                $courseData = Auth::user()->nceCourseData()->first();
                
                $nceCoursePayment = $this->nceCoursePayment->where([
                    'course_id' => $courseData->admitted_course_id
                ])->first();

                if($nceCoursePayment == null)
                {
                    throw new Exception('Nce Course Payment has not been set', 404);
                }
                
                $currentSession = $this->nceAcademicSession->getCurrentSession();
                $interswitchPayment = $this->nceRegistrationPayment->where([
                    'user_id' => Auth::id(),
                    'course_id' => $courseData->admitted_course_id,
                    'nce_academic_session_id' => $currentSession->id,
                ])->first();
                
                if($interswitchPayment == null)
                {
                    $referenceCode = generateTransactionReferenceCode();

                    $interswitchPayment = $this->nceRegistrationPayment->create([
                        'user_id' => Auth::id(),
                        'nce_academic_session_id' => $currentSession->id,
                        'reference_code' => $referenceCode,
                        'amount' => $nceCoursePayment->amount,
                        'course_id' => $courseData->admitted_course_id
                    ]);
                }
                
                $merchantCode = env('INTERSWITCH_MERCHANT_CODE');
                $payItemId = env('INTERSWITCH_PAY_ITEM_ID');

                $data['reference_code'] = $interswitchPayment->reference_code;
                $data['email_address'] = $contactData->email_address;
                $data['full_name'] = "{$personalData->surname} {$personalData->other_names}";
                $data['merchant_code'] = $merchantCode;
                $data['pay_item_id'] = $payItemId;
                $data['amount'] = ($interswitchPayment->amount * 100);
                $data['url'] = 'https://qa.interswitchng.com/collections/w/pay';

                return successParser($data, 201);
            }
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
}
