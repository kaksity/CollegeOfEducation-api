<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\NceApplicationPayment;
use App\Services\Interfaces\Payments\InterswitchServiceInterface;
use App\Services\Interfaces\Payments\RemitaServiceInterface;
use Exception;

class VerifyNceApplicationPayment
{
    public function __construct(
        private NceApplicationPayment $applicationPayment,
        private RemitaServiceInterface $remitaServiceInterface,
        private InterswitchServiceInterface $interswitchServiceInterface
    )
    {}
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
            $payment = $this->applicationPayment->where([
                'user_id' => Auth::id(),
            ])->first();
            
            if ($payment == null) {
                $data['message'] = 'Applicant is yet to pay application fee';
                $data['error_code'] = 'APPLICATION_PAYMENT_ERROR';
                return errorParser($data, 403);
            } elseif ($payment->status != 'paid') {
                if ($payment->payment_gateway == 'interswitch') {

                    $response = $this->interswitchServiceInterface->verifyTransaction([
                        'reference_code' => $payment->reference_code,
                        'amount' => $payment->amount,
                    ]);

                    if ($response['transaction_code'] != '00') {
                        $data['message'] = 'Applicant is yet to pay application fee';
                        $data['error_code'] = 'APPLICATION_PAYMENT_ERROR';
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
                        $data['message'] = 'Applicant is yet to pay application fee';
                        $data['error_code'] = 'APPLICATION_PAYMENT_ERROR';
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
