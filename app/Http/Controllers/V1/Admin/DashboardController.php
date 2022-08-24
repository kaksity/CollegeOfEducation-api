<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{ NceApplicationStatus, NceRegistrationPayment, NceApplicationPayment };
class DashboardController extends Controller
{
    public function __construct(NceApplicationStatus $nceApplicationStatus, NceRegistrationPayment $nceRegistrationPayment, NceApplicationPayment $nceApplicationPayment)
    {
        $this->nceApplicationStatus = $nceApplicationStatus;
        $this->nceRegistrationPayment = $nceRegistrationPayment;
        $this->nceApplicationPayment = $nceApplicationPayment;
    }
    public function index()
    {
        $admittedApplicants = $this->nceApplicationStatus->where([
            'status' => 'admitted'
        ])->get()->count();
        $rejectedApplicants = $this->nceApplicationStatus->where([
            'status' => 'rejected'
        ])->get()->count();
        $pendingApplicants = $this->nceApplicationStatus->where([
            'status' => 'pending'
        ])->get()->count();

        $nceRegistrationPayments = $this->nceRegistrationPayment->get()->count();
        $nceApplicationPayments = $this->nceApplicationPayment->get()->count();

        $applicants['total_applicants'] = $admittedApplicants + $rejectedApplicants +$pendingApplicants;
        $applicants['admitted_applicants'] = $admittedApplicants;
        $applicants['rejected_applicants'] = $rejectedApplicants;
        $applicants['pending_applicants'] = $pendingApplicants;
        
        $payments['application_payments'] = $nceApplicationPayments;
        $payments['registration_payments'] = $nceRegistrationPayments;


        $data['applicants'] = $applicants;
        $data['payments'] = $payments;
        
        return successParser($data);
    }
}
