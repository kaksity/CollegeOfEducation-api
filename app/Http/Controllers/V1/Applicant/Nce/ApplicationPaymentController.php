<?php

namespace App\Http\Controllers\V1\Applicant\Nce;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\ApplicationPayment\ApplicationPaymentRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ApplicationPaymentController extends Controller
{
    public function initiatePayment(ApplicationPaymentRequest $request)
    {
        try
        {
            if($request->payment_gateway == 'remita')
            {

                $personalData = Auth::user()->dipPersonalData()->first();
                $contactData = Auth::user()->dipContactData()->first();                
                
                $merchantId = env('REMITA_MERCHANT_ID');
                $remitaSecretKey = env('REMITA_SECRET_KEY');

                $amount = 1000;
                
                $serviceTypeId =  env('REMITA_APPLICATION_FORM_SERVICE_TYPE');

                $orderId = generateRandomString(8)."".round(microtime(true) * 1000)."".generateRandomNumber(8);
                
                $apiHash = hash('sha512',"{$merchantId}{$serviceTypeId}{$orderId}{$amount}{$remitaSecretKey}");
                
                $requestBody = [
                    "serviceTypeId" => $serviceTypeId,
                    "amount" => $amount,
                    "orderId" => $orderId,
                    "payerName" => "{$personalData->surname} {$personalData->other_names}",
                    "payerEmail" => $contactData->email_address,
                    "payerPhone" => "09062067384",
                    "description" => "Payment of College of Education Waka-Biu Application Fees"
                ];
                
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => "remitaConsumerKey={$merchantId},remitaConsumerToken={$apiHash}"
                ])->post('https://remitademo.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit', $requestBody);

                dd($response->body());
            }
            else if ($request->payment_gateway == 'interswitch')
            {
                
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
