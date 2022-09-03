<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\NceApplicationPayment\NceApplicationPaymentRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\{ApplicantSetPayment, NceApplicationPayment };

class ApplicationPaymentController extends Controller
{
    public function __construct(NceApplicationPayment $NceApplicationPayment, ApplicantSetPayment $applicantSetPayment)
    {
        $this->NceApplicationPayment = $NceApplicationPayment;
        $this->applicantSetPayment = $applicantSetPayment;
    }
    public function initiatePayment(NceApplicationPaymentRequest $request)
    {
        try
        {
            if ($request->payment_gateway == 'interswitch')
            {

                $personalData = Auth::user()->ncePersonalData()->first();
                $courseData = Auth::user()->nceCourseData()->first();
                $applicantSetPayment = $this->applicantSetPayment->where('course_group_id', $courseData->course_group_id)->first();
                if($applicantSetPayment == null)
                {
                    throw new Exception('Admin is yet to set the application payment amount', 400);
                }
                $contactData = Auth::user()->nceContactData()->first();                

                $interswitchPayment = $this->NceApplicationPayment->where([
                    'user_id' => Auth::id()
                ])->first();

                if($interswitchPayment == null)
                {
                    $referenceCode = generateTransactionReferenceCode();

                    $interswitchPayment = $this->NceApplicationPayment->create([
                        'user_id' => Auth::id(),
                        'reference_code' => $referenceCode,
                        'amount' => $applicantSetPayment->amount
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
