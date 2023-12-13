<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\NceApplicationPayment\NceApplicationPaymentRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\{AdmissionPayment, AdmissionSetPayment, ApplicantSetPayment, NceApplicationPayment };
use App\Services\Interfaces\Payments\InterswitchServiceInterface;
use App\Services\Interfaces\Payments\RemitaServiceInterface;

class PaymentController extends Controller
{
    public function __construct(
        private NceApplicationPayment $applicationPayment,
        private ApplicantSetPayment $applicantSetPayment,
        private AdmissionSetPayment $admissionSetPayment,
        private AdmissionPayment $admissionPayment,
        private RemitaServiceInterface $remitaServiceInterface,
        private InterswitchServiceInterface $interswitchServiceInterface
    )
    {
    }
    public function initiateApplicationPayment(NceApplicationPaymentRequest $request)
    {
        try
        {
            if ($request->payment_gateway == 'interswitch') {

                $personalData = Auth::user()->ncePersonalData;
                $courseData = Auth::user()->nceCourseData;

                $interswitchConfigurations = $this->interswitchServiceInterface->getInterswitchConfigurations();

                $applicantSetPayment = $this->applicantSetPayment->where([
                    'course_group_id' => $courseData->course_group_id
                ])->first();

                if (is_null($applicantSetPayment)) {
                    throw new Exception('Admin is yet to set the application payment amount', 400);
                }
                $contactData = Auth::user()->nceContactData;

                $interswitchPayment = $this->applicationPayment->where([
                    'user_id' => Auth::id()
                ])->first();

                if ($interswitchPayment == null) {
                    $referenceCode = generateTransactionReferenceCode();

                    $interswitchPayment = $this->applicationPayment->create([
                        'user_id' => Auth::id(),
                        'reference_code' => $referenceCode,
                        'amount' => $applicantSetPayment->amount,
                        'payment_gateway' => 'interswitch',
                    ]);
                } elseif (is_null($interswitchPayment->reference_code)) {
                    $referenceCode = generateTransactionReferenceCode();
                    $interswitchPayment->update([
                        'reference_code' => $referenceCode,
                        'payment_gateway' => 'interswitch',
                    ]);
                } else {
                    $interswitchPayment->update([
                        'payment_gateway' => 'interswitch',
                    ]);
                }

                $data['reference_code'] = $interswitchPayment->reference_code;
                $data['email_address'] = $contactData->email_address;
                $data['full_name'] = "{$personalData->surname} {$personalData->other_names}";
                $data['merchant_code'] = $interswitchConfigurations['merchant_code'];
                $data['pay_item_id'] = $interswitchConfigurations['pay_item_id'];
                $data['amount'] = ($interswitchPayment->amount * 100);
                $data['url'] = 'https://qa.interswitchng.com/collections/w/pay';

                return successParser($data, 201);
            } elseif ($request->payment_gateway == 'remita') {
                
                $personalData = Auth::user()->ncePersonalData;
                $courseData = Auth::user()->nceCourseData;
                
                $applicationSetPayment = $this->applicantSetPayment->where([
                    'course_group_id' => $courseData->course_group_id
                ])->first();
                
                if ($applicationSetPayment == null) {
                    throw new Exception('Admin is yet to set the application payment amount', 400);
                }
                $contactData = Auth::user()->nceContactData;

                $remitaPayment = $this->applicationPayment->where([
                    'user_id' => Auth::id()
                ])->first();

                $remitaConfigurations = $this->remitaServiceInterface->getRemitaConfigurations();

                if ($remitaPayment == null) {

                    $response = $this->remitaServiceInterface->initiatePayment([
                        'amount' => $applicationSetPayment->amount,
                        'surname' => $personalData->surname,
                        'other_names' => $personalData->other_names,
                        'service_type_id' => $applicationSetPayment->remita_service_type,
                        'email_address' =>  $contactData->email_address,
                        'phone_number' => $contactData->phone_number,
                        'description' => 'Payment for Application Fees'
                    ]);
                    $remitaPayment = $this->applicationPayment->create([
                        'user_id' => Auth::id(),
                        'order_id' => $response['order_id'],
                        'rrr' => $response['rrr'],
                        'amount' => $applicationSetPayment->amount,
                        'payment_gateway' => 'remita',
                    ]);
                } elseif (is_null($remitaPayment->rrr) && is_null($remitaPayment->order_id)) {
                    $response = $this->remitaServiceInterface->initiatePayment([
                        'amount' => $applicationSetPayment->amount,
                        'surname' => $personalData->surname,
                        'other_names' => $personalData->other_names,
                        'service_type_id' => $applicationSetPayment->remita_service_type,
                        'email_address' =>  $contactData->email_address,
                        'phone_number' => $contactData->phone_number,
                        'description' => 'Payment for Application Fees'
                    ]);

                    $remitaPayment->update([
                        'order_id' => $response['order_id'],
                        'rrr' => $response['rrr'],
                        'payment_gateway' => 'remita',
                    ]);
                } else {
                    $remitaPayment->update([
                        'payment_gateway' => 'remita'
                    ]);
                }

                $data['rrr'] = $remitaPayment->rrr;
                $data['email_address'] = $contactData->email_address;
                $data['full_name'] = "{$personalData->surname} {$personalData->other_names}";
                $data['merchant_id'] = $remitaConfigurations['merchant_id'];
                $data['amount'] = $remitaPayment->amount;

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
    public function initiateAdmissionPayment(NceApplicationPaymentRequest $request)
    {
        try
        {
            if ($request->payment_gateway == 'interswitch')
            {

                $personalData = Auth::user()->ncePersonalData;
                $courseData = Auth::user()->nceCourseData;
                $interswitchConfigurations = $this->interswitchServiceInterface->getInterswitchConfigurations();
                
                $admissionSetPayment = $this->admissionSetPayment->where([
                    'course_group_id' => $courseData->course_group_id
                ])->first();
                
                if ($admissionSetPayment == null) {
                    throw new Exception('Admin is yet to set the admission payment amount', 400);
                }
                $contactData = Auth::user()->nceContactData;

                $interswitchPayment = $this->admissionPayment->where([
                    'user_id' => Auth::id()
                ])->first();

                if ($interswitchPayment == null) {
                    $referenceCode = generateTransactionReferenceCode();

                    $interswitchPayment = $this->admissionPayment->create([
                        'user_id' => Auth::id(),
                        'reference_code' => $referenceCode,
                        'amount' => $admissionSetPayment->amount,
                        'payment_gateway' => 'interswitch',
                        'course_group_id' => $courseData->course_group_id,
                    ]);
                } elseif (is_null($interswitchPayment->reference_code)) {
                    $referenceCode = generateTransactionReferenceCode();
                    $interswitchPayment->update([
                        'reference_code' => $referenceCode,
                        'payment_gateway' => 'interswitch',
                    ]);
                } else {
                    $interswitchPayment->update([
                        'payment_gateway' => 'interswitch',
                    ]);
                }

                $data['reference_code'] = $interswitchPayment->reference_code;
                $data['email_address'] = $contactData->email_address;
                $data['full_name'] = "{$personalData->surname} {$personalData->other_names}";
                $data['merchant_code'] = $interswitchConfigurations['merchant_code'];
                $data['pay_item_id'] = $interswitchConfigurations['pay_item_id'];
                $data['amount'] = ($interswitchPayment->amount * 100);
                $data['url'] = $interswitchConfigurations['url'];

                return successParser($data, 201);
            } elseif ($request->payment_gateway == 'remita') {
                $personalData = Auth::user()->ncePersonalData;
                $courseData = Auth::user()->nceCourseData;
                
                $admissionSetPayment = $this->admissionSetPayment->where([
                    'course_group_id' => $courseData->course_group_id
                ])->first();
                
                if ($admissionSetPayment == null) {
                    throw new Exception('Admin is yet to set the admission payment amount', 400);
                }

                $contactData = Auth::user()->nceContactData;

                $remitaPayment = $this->admissionPayment->where([
                    'user_id' => Auth::id()
                ])->first();
                $remitaConfigurations = $this->remitaServiceInterface->getRemitaConfigurations();
                
                if ($remitaPayment == null) {

                    $response = $this->remitaServiceInterface->initiatePayment([
                        'amount' => $admissionSetPayment->amount,
                        'surname' => $personalData->surname,
                        'other_names' => $personalData->other_names,
                        'service_type_id' => $admissionSetPayment->remita_service_type,
                        'email_address' =>  $contactData->email_address,
                        'phone_number' => $contactData->phone_number,
                        'description' => 'Payment for Admission Fees'
                    ]);
                    
                    $remitaPayment = $this->admissionPayment->create([
                        'user_id' => Auth::id(),
                        'order_id' => $response['order_id'],
                        'rrr' => $response['rrr'],
                        'amount' => $admissionSetPayment->amount,
                        'payment_gateway' => 'remita',
                        'course_group_id' => $courseData->course_group_id,
                    ]);
                } elseif (is_null($remitaPayment->rrr) && is_null($remitaPayment->order_id)) {
                    $response = $this->remitaServiceInterface->initiatePayment([
                        'amount' => $admissionSetPayment->amount,
                        'surname' => $personalData->surname,
                        'other_names' => $personalData->other_names,
                        'service_type_id' => $admissionSetPayment->remita_service_type,
                        'email_address' =>  $contactData->email_address,
                        'phone_number' => $contactData->phone_number,
                        'description' => 'Payment for Admission Fees'
                    ]);

                    $remitaPayment->update([
                        'order_id' => $response['order_id'],
                        'rrr' => $response['rrr'],
                        'payment_gateway' => 'remita',
                    ]);
                } else {
                    $remitaPayment->update([
                        'payment_gateway' => 'remita'
                    ]);
                }

                $data['rrr'] = $remitaPayment->rrr;
                $data['email_address'] = $contactData->email_address;
                $data['full_name'] = "{$personalData->surname} {$personalData->other_names}";
                $data['merchant_id'] = $remitaConfigurations['merchant_id'];
                $data['amount'] = $remitaPayment->amount;

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
