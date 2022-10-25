<?php

namespace App\Http\Controllers\V1\Admin\Bursary;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\Bursary\ProcessedApplicationResource;
use App\Models\NceApplicationPayment;
use App\Services\Interfaces\Bursary\ApplicationPaymentServiceInterface;
use Illuminate\Http\Request;

class ApplicantProcessedPaymentController extends Controller
{
    public function __construct(private ApplicationPaymentServiceInterface $applicationPaymentServiceInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 100;
        $processedApplicationPayments = $this->applicationPaymentServiceInterface
                                            ->getAllProcessedApplicationPayments($perPage);
        return ProcessedApplicationResource::collection($processedApplicationPayments);
    }
}
