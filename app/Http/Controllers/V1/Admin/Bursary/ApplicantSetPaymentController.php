<?php

namespace App\Http\Controllers\V1\Admin\Bursary;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Bursary\ApplicantSetPayment\ApplicantSetPaymentRequest;
use App\Http\Resources\V1\Admin\Bursary\ApplicantSetPaymentResource;
use App\Models\ApplicantSetPayment;
use App\Services\Interfaces\Bursary\ApplicationPaymentServiceInterface;
use Exception;
use Illuminate\Http\Request;

class ApplicantSetPaymentController extends Controller
{

    public function __construct(private ApplicationPaymentServiceInterface $applicationPaymentServiceInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applicationSetPayments = $this->applicationPaymentServiceInterface->getAllSetApplicationPayments();

        return ApplicantSetPaymentResource::collection($applicationSetPayments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicantSetPaymentRequest $request)
    {
        try
        {
            $applicationSetPayment = $this->applicationPaymentServiceInterface
                                            ->getSetApplicationPaymentByCourseGroup($request->course_group_id);

            if($applicationSetPayment != null)
            {
                throw new Exception('Applicant set payment record already exist', 400);
            }

            $this->applicationPaymentServiceInterface->createNewSetApplicationPayments($request->safe()->all());

            $data['message'] = 'Applicant set payment record was created successfully';
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
    public function update(ApplicantSetPaymentRequest $request, $id)
    {
        try
        {
            $applicationSetPayment = $this->applicationPaymentServiceInterface->getSetApplicationPaymentById($id);

            if($applicationSetPayment == null)
            {
                throw new Exception('Applicant set payment record does not exist', 404);
            }

            $applicationSetPayment->course_group_id = $request->course_group_id;
            $applicationSetPayment->amount = $request->amount;

            $this->applicationPaymentServiceInterface->updateSetApplicationPayment($applicationSetPayment);

            $data['message'] = 'Applicant set payment record was updated successfully';
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
            $applicationSetPayment = $this->applicationPaymentServiceInterface->getSetApplicationPaymentById($id);

            if($applicationSetPayment == null)
            {
                throw new Exception('Applicant set payment record does not exist', 404);
            }

            $this->applicationPaymentServiceInterface->deleteSetApplicationPayment($applicationSetPayment);
            
            $data['message'] = 'Applicant set payment record was deleted successfully';

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
