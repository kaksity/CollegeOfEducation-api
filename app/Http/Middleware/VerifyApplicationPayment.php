<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\ApplicationPayment;
class VerifyApplicationPayment
{
    public function __construct(ApplicationPayment $applicationPayment)
    {
        $this->applicationPayment = $applicationPayment;
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
        $payment = $this->applicationPayment->where([
            'user_id' => Auth::id(),
        ])->first();
        
        if($payment == null)
        {
            $data['message'] = 'Applicant is yet to pay application fee(null)';
            return errorParser($data, 403);
        }
        else if ($payment->status != 'paid')
        {
            $merchantCode = env('INTERSWITCH_MERCHANT_CODE');
            $referenceCode = $payment->reference_code;
            $amount = $payment->amount;
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->get("https://qa.interswitchng.com/collections/api/v1/gettransaction.json?merchantCode={$merchantCode}&transactionReference={$referenceCode}&amount={$amount}");
            
            $responseData = json_decode($response->body());
            if($responseData->ResponseCode != '00')
            {
                $data['message'] = 'Applicant is yet to pay application fee';
                $data['response'] = $responseData;
                return errorParser($data, 403);
            }

            $payment->update([
                'status' => 'paid'
            ]);
        }
        
        return $next($request);
    }
}
