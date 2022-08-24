<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\NceApplicationPayment;
use Exception;

class VerifyNceIdNumberSet
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
            $nceApplicationStatus = Auth::user()->nceApplicationStatus()->first();
            if($nceApplicationStatus->id_number == null || $nceApplicationStatus->id_number == '')
            {
                $data['message'] = 'Student Id Number is not set';
                $data['error_code'] = 'ID_NUMBER_ERROR';
                return errorParser($data, 403);
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
