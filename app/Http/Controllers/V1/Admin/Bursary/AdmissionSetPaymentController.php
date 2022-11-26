<?php

namespace App\Http\Controllers\V1\Admin\Bursary;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Bursary\AdmissionSetPayment\AdmissionSetPaymentRequest;
use App\Http\Requests\V1\Admin\Bursary\ApplicationSetPayment\ApplicationSetPaymentRequest;
use App\Http\Resources\V1\Admin\Bursary\AdmissionSetPaymentResource;
use App\Models\AdmissionSetPayment;
use App\Services\Interfaces\Bursary\AdmissionPaymentServiceInterface;
use Illuminate\Http\Request;
use Exception;

class AdmissionSetPaymentController extends Controller
{

    public function __construct(private AdmissionPaymentServiceInterface $admissionPaymentServiceInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admissionSetPayment = $this->admissionPaymentServiceInterface->getAllSetAdmissionPayments();

        return AdmissionSetPaymentResource::collection($admissionSetPayment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdmissionSetPaymentRequest $request)
    {
        try
        {
            $admissionSetPayment = $this->admissionPaymentServiceInterface->getSetAdmissionPaymentByCourseGroup($request->course_group_id);

            if($admissionSetPayment != null)
            {
                throw new Exception('Admission set payment record already exist', 400);
            }

            $this->admissionPaymentServiceInterface->createNewSetAdmissionPayments($request->safe()->all());

            $data['message'] = 'Admission set payment record was created successfully';
            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();

            return errorParser($data, $code);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $admissionSetPayment = $this->admissionPaymentServiceInterface->getSetAdmissionPaymentById($id);

            if($admissionSetPayment == null)
            {
                throw new Exception('Admission set payment record does not exist', 404);
            }

            $admissionSetPayment->course_group_id = $request->course_group_id;
            $admissionSetPayment->amount = $request->amount;
            
            $this->admissionPaymentServiceInterface->updateSetAdmissionPayment($admissionSetPayment);

            $data['message'] = 'Admission set payment record was updated successfully';
            return successParser($data);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();

            return errorParser($data, $code);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $admissionSetPayment = $this->admissionPaymentServiceInterface->getSetAdmissionPaymentById($id);
            
            if($admissionSetPayment == null)
            {
                throw new Exception('Admission set payment record does not exist', 404);
            }

            $this->admissionPaymentServiceInterface->deleteSetAdmissionPayment($admissionSetPayment);
            
            $data['message'] = 'Admission set payment record was deleted successfully';

            return successParser($data);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();

            return errorParser($data, $code);
        }
    }
}
