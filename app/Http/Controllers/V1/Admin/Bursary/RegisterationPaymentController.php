<?php

namespace App\Http\Controllers\V1\Admin\Bursary;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\Bursary\NceRegisterationPaymentResource;
use Illuminate\Http\Request;
use App\Models\NceRegistrationPayment;
use App\Services\Interfaces\Bursary\CoursePaymentServiceInterface;

class RegisterationPaymentController extends Controller
{
    public function __construct(private CoursePaymentServiceInterface $coursePaymentServiceInterface)
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 50;

        $nceRegistrationPayments = $this->coursePaymentServiceInterface->getAllProcessedRegisterationPayments($perPage);
        return NceRegisterationPaymentResource::collection($nceRegistrationPayments);
    }    
}
