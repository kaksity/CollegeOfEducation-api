<?php

namespace App\Http\Middleware;

use App\Models\NceAcademicSession;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\NceApplicationPayment;
use App\Models\NceRegistrationPayment;
use Exception;

class VerifyNceRegisterationPayment
{
    public function __construct(NceRegistrationPayment $nceRegistrationPayment, NceAcademicSession $nceAcademicSession)
    {
        $this->nceRegistrationPayment = $nceRegistrationPayment;
        $this->nceAcademicSession = $nceAcademicSession;
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
            
            if($payment == null)
            {
                $data['message'] = 'Student is yet to pay registeration fee';
                $data['error_code'] = 'REGISTRATION_PAYMENT_ERROR';
                return errorParser($data, 403);
            }
            else if ($payment->status != 'paid')
            {
                $merchantCode = env('INTERSWITCH_MERCHANT_CODE');
                $url = env('INTERSWITCH_PAYMENT_URL');
                $referenceCode = $payment->reference_code;
                $amount = $payment->amount * 100;
                $url = "$url/gettransaction.json?merchantcode=$merchantCode&transactionreference=$referenceCode&amount=$amount";
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->get($url);
                
                $responseData = json_decode($response->body());
                if($responseData->ResponseCode != '00')
                {
                    $data['message'] = 'Student is yet to pay registeration fee';
                    $data['error_code'] = 'REGISTRATION_PAYMENT_ERROR';
                    return errorParser($data, 403);
                }
    
                $payment->update([
                    'status' => 'paid'
                ]);
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
