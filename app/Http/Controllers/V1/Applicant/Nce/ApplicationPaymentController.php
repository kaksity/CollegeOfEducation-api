<?php

namespace App\Http\Controllers\V1\Applicant\Nce;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\ApplicationPayment\ApplicationPaymentRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\{ ApplicationPayment };

class ApplicationPaymentController extends Controller
{
    public function __construct(ApplicationPayment $applicationPayment)
    {
        $this->applicationPayment = $applicationPayment;
    }
    public function initiatePayment(ApplicationPaymentRequest $request)
    {
        try
        {
            if($request->payment_gateway == 'remita')
            {

                $merchantId = env('REMITA_MERCHANT_ID');
                $remitaSecretKey = env('REMITA_SECRET_KEY');
                $amount = 1000;
                    
                $serviceTypeId =  env('REMITA_APPLICATION_FORM_SERVICE_TYPE');

                $orderId = generateRandomString(8)."".round(microtime(true) * 1000)."".generateRandomNumber(8);
                
                $apiHash = hash('sha512',"{$merchantId}{$serviceTypeId}{$orderId}{$amount}{$remitaSecretKey}");

                $remitaPayment = $this->applicationPayment->where([
                    'user_id' => Auth::id()
                ])->first();
                
                if($remitaPayment == null)
                {
                    $personalData = Auth::user()->dipPersonalData()->first();
                    $contactData = Auth::user()->dipContactData()->first();                

                    
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

                    $responseData = json_decode($response->body());
                    // Save the data to the database
                    $this->applicationPayment->create([
                        'user_id' => Auth::id(),
                        'reference_code' => $responseData->RRR,
                        'order_id' => $orderId
                    ]);

                    $data['message'] = $responseData->status;
                    $data['rrr'] = $responseData->RRR;
                    $data['url'] = 'https://remitademo.net/remita/ecomm/finalize.reg';
                    $data['merchant_id'] = $merchantId;
                    $data['hash'] = $apiHash;

                }
                else {
                    $data['message'] = 'Remita payment generated';
                    $data['rrr'] = $remitaPayment->reference_code;
                    $data['url'] = 'https://remitademo.net/remita/ecomm/finalize.reg';
                    $data['merchant_id'] = $merchantId;
                    $data['hash'] = $apiHash;
                }

                return successParser($data, 201);
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
