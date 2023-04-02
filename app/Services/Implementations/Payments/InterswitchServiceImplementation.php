<?php

namespace App\Services\Implementations\Payments;

use App\Services\Interfaces\Payments\InterswitchServiceInterface;
use Illuminate\Support\Facades\Http;

class InterswitchServiceImplementation implements InterswitchServiceInterface
{
    public function getInterswitchConfigurations()
    {
        return [
            'merchant_code' => env('INTERSWITCH_MERCHANT_CODE'),
            'pay_item_id' => env('INTERSWITCH_PAY_ITEM_ID'),
            'url' => env('INTERSWITCH_PAYMENT_URL'),
        ];
    }

    public function verifyTransaction($options)
    {
        $interswitchConfigurations = $this->getInterswitchConfigurations();
        $merchantCode = $interswitchConfigurations['merchant_code'];
        $referenceCode = $options['reference_code'];
        $url = $interswitchConfigurations['url'];
        $amount = $options['amount'] * 100;

        $url = "$url/gettransaction.json?merchantcode=$merchantCode&transactionreference=$referenceCode&amount=$amount";
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->get($url);
        
        $responseData = json_decode($response->body());

        return [
            'transaction_code' => $responseData->ResponseCode,
        ];
    }
}
