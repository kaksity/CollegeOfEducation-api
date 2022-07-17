<?php

namespace App\Http\Controllers\V1\Applicant\Nce;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\NceApplicationPayment\NceApplicationPaymentRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\{ NceApplicationPayment };

class ApplicationPaymentController extends Controller
{
    public function __construct(NceApplicationPayment $NceApplicationPayment)
    {
        $this->NceApplicationPayment = $NceApplicationPayment;
    }
    public function initiatePayment(NceApplicationPaymentRequest $request)
    {
        try
        {
            if ($request->payment_gateway == 'interswitch')
            {

                $personalData = Auth::user()->ncePersonalData()->first();
                $contactData = Auth::user()->nceContactData()->first();                

                $interswitchPayment = $this->NceApplicationPayment->where([
                    'user_id' => Auth::id()
                ])->first();

                if($interswitchPayment == null)
                {
                    $referenceCode = generateRandomString(8)."".round(microtime(true) * 1000)."".generateRandomNumber(8);

                    $interswitchPayment = $this->NceApplicationPayment->create([
                        'user_id' => Auth::id(),
                        'reference_code' => $referenceCode,
                        'amount' => 1000
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
