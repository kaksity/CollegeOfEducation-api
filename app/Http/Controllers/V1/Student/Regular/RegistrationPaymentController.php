<?php

namespace App\Http\Controllers\V1\Student\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Student\CourseRegisterationPin\CourseRegisterationPinRequest;
use App\Http\Requests\V1\Student\NceRegistrationPayment\NceRegisterationPaymentRequest;
use App\Models\CourseRegisterationCard;
use App\Models\NceAcademicSession;
use App\Models\NceCoursePayment;
use App\Models\NceRegistrationPayment;
use App\Models\UsedCourseRegisterationPin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationPaymentController extends Controller
{
    public function __construct( CourseRegisterationCard $courseRegisterationCard, UsedCourseRegisterationPin $usedCourseRegisterationPin,NceAcademicSession $nceAcademicSession, NceCoursePayment $nceCoursePayment, NceRegistrationPayment $nceRegistrationPayment)
    {
        $this->courseRegisterationCard = $courseRegisterationCard;
        $this->nceRegistrationPayment = $nceRegistrationPayment;
        $this->nceCoursePayment = $nceCoursePayment;
        $this->nceAcademicSession = $nceAcademicSession;
        $this->usedCourseRegisterationPin = $usedCourseRegisterationPin;
    }
    public function useCourseRegisterationPin(CourseRegisterationPinRequest $request) {
        try
        {
            $courseData = Auth::user()->nceCourseData()->first();
            $currentSession = $this->nceAcademicSession->getCurrentSession($courseData->course_group_id);
    
            $card = $this->courseRegisterationCard->where([
                'academic_session_id' => $currentSession->id,
                'course_group_id' => $courseData->course_group_id,
                'pin' => $request->course_registeration_pin,
                'status' => 'active'
            ])->first();
    
            if($card == null)
            {
                throw new Exception('Course Registeration Pin is invalid', 400);
            }
            
            // Check if the pin has already been used by another student
            $usedCard = $this->usedCourseRegisterationPin->where([
                'card_id' => $card->id,
            ])->first();
            if($usedCard != null && $usedCard->user_id != Auth::id())
            {
                throw new Exception('This Card has already been used by another student', 400);
            }

            DB::beginTransaction();
            $card->update([
                'used_counter' => $card->used_counter + 1
            ]);

            if ($usedCard == null)
            {
                $this->usedCourseRegisterationPin->create([
                    'card_id' => $card->id,
                    'user_id' => Auth::id(),
                    'academic_session_id' => $currentSession->id,

                ]);
            }
            DB::commit();

            $data['message'] = 'User Card Pin was used';
            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            DB::rollBack();
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
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
                    throw new Exception('Course Payment has not been set', 404);
                }
                
                $currentSession = $this->nceAcademicSession->getCurrentSession($courseData->course_group_id);
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
