<?php

namespace App\Http\Controllers\V1\Admin\Bursary;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\Bursary\ProcessedApplicationResource;
use App\Models\NceApplicationPayment;
use Illuminate\Http\Request;

class ApplicantProcessedPaymentController extends Controller
{
    public function __construct(NceApplicationPayment $nceApplicationPayment)
    {
        $this->nceApplicationPayment = $nceApplicationPayment;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 100;
        $nceApplicationPayments = $this->nceApplicationPayment->latest()->paginate($perPage);
        return ProcessedApplicationResource::collection($nceApplicationPayments);
    }
}
