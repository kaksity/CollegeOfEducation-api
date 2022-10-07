<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\NceApplicationPayment;
use Exception;

class VerifyNceApplicationPayment
{
    public function __construct(NceApplicationPayment $NceApplicationPayment)
    {
        $this->NceApplicationPayment = $NceApplicationPayment;
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
            $payment = $this->NceApplicationPayment->where([
                'user_id' => Auth::id(),
            ])->first();
            
            if($payment == null)
            {
                $data['message'] = 'Applicant is yet to pay application fee';
                $data['error_code'] = 'APPLICATION_PAYMENT_ERROR';
                return errorParser($data, 403);
            }
            else if ($payment->status != 'paid')
            {
                $merchantCode = env('INTERSWITCH_MERCHANT_CODE');
                $referenceCode = $payment->reference_code;
                $url = env('INTERSWITCH_PAYMENT_URL');

                $amount = $payment->amount * 100;
                
                $url = "$url/gettransaction.json?merchantcode=$merchantCode&transactionreference=$referenceCode&amount=$amount";
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->get($url);
                
                $responseData = json_decode($response->body());
                if($responseData->ResponseCode != '00')
                {
                    $data['message'] = 'Applicant is yet to pay application fee';
                    $data['error_code'] = 'APPLICATION_PAYMENT_ERROR';
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
