<?php

namespace App\Http\Controllers\V1\Admin\Bursary;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\Bursary\NceRegisterationPaymentResource;
use Illuminate\Http\Request;
use App\Models\NceRegistrationPayment;

class NceRegisterationPaymentController extends Controller
{
    public function __construct(NceRegistrationPayment $nceRegistrationPayment)
    {
        $this->nceRegistrationPayment = $nceRegistrationPayment;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 50;
        $nceRegistrationPayments = $this->nceRegistrationPayment->with(['nceStudent.nceApplicationStatus', 'nceSession', 'nceCourse', 'nceStudent'])->latest()->paginate($perPage);
        return NceRegisterationPaymentResource::collection($nceRegistrationPayments);
    }    
}
