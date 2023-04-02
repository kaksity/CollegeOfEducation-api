<?php

namespace App\Http\Middleware;

use App\Models\NceAcademicSession;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\NceApplicationPayment;
use App\Models\NceRegistrationPayment;
use App\Services\Interfaces\Payments\InterswitchServiceInterface;
use App\Services\Interfaces\Payments\RemitaServiceInterface;
use Exception;

class VerifyNceRegisterationPayment
{
    public function __construct(
        private NceRegistrationPayment $nceRegistrationPayment,
        private NceAcademicSession $nceAcademicSession,
        private RemitaServiceInterface $remitaServiceInterface,
        private InterswitchServiceInterface $interswitchServiceInterface
    )
    {
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try
        {
            $courseData = Auth::user()->nceCourseData;
            $currentSession = $this->nceAcademicSession->getCurrentSession($courseData->course_group_id);


            $payment = $this->nceRegistrationPayment->where([
                'user_id' => Auth::id(),
                'nce_academic_session_id' => $currentSession->id
            ])->first();
            
            
            if ($payment == null) {
                $data['message'] = 'Student is yet to pay registration fee';
                $data['error_code'] = 'REGISTRATION_PAYMENT_ERROR';
                return errorParser($data, 403);
            } elseif ($payment->status != 'paid') {
                if ($payment->payment_gateway == 'interswitch') {

                    $response = $this->interswitchServiceInterface->verifyTransaction([
                        'reference_code' => $payment->reference_code,
                        'amount' => $payment->amount,
                    ]);

                    if ($response['transaction_code'] != '00') {
                        $data['message'] = 'Student is yet to pay registration fee';
                        $data['error_code'] = 'REGISTRATION_PAYMENT_ERROR';
                        return errorParser($data, 403);
                    }

                    $payment->update([
                        'status' => 'paid'
                    ]);
                } elseif ($payment->payment_gateway == 'remita') {

                    $response = $this->remitaServiceInterface->verifyPayment([
                        'rrr' => $payment->rrr,
                    ]);

                    if($response['transaction_code'] != '00')
                    {
                        $data['message'] = 'Student is yet to pay registration fee';
                        $data['error_code'] = 'REGISTRATION_PAYMENT_ERROR';
                        return errorParser($data, 403);
                    }

                    $payment->update([
                        'status' => 'paid'
                    ]);
                }
            }
            
            return $next($request);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
        
    }
}
