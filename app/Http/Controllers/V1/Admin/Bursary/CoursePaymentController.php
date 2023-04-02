<?php

namespace App\Http\Controllers\V1\Admin\Bursary;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Bursary\NceCoursePayment\NceCoursePaymentRequest;
use App\Http\Resources\V1\Admin\Bursary\NceCoursePaymentResource;
use Exception;
use App\Services\Interfaces\Bursary\CoursePaymentServiceInterface;
use App\Services\Interfaces\GeneralSettings\CourseServiceInterface;

class CoursePaymentController extends Controller
{
    public function __construct(private CoursePaymentServiceInterface $coursePaymentServiceInterface, private CourseServiceInterface $courseServiceInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NceCoursePaymentRequest $request)
    {
        $perPage = $request->per_page ?? 20;
        $coursePayments = $this->coursePaymentServiceInterface->getAllSetCoursePayments($perPage);
        return NceCoursePaymentResource::collection($coursePayments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NceCoursePaymentRequest $request)
    {
        try
        {
            // Check if the course exist
            $course = $this->courseServiceInterface->getCourseById($request->course_id);

            if ($course == null)
            {
                throw new Exception('Course Record does not exist', 404);
            }

            $doesCoursePaymentExists = $this->coursePaymentServiceInterface
                                            ->checkIfCoursePaymentAlreadyExists($request->safe()->all());
            
            if ($doesCoursePaymentExists == true)
            {
                throw new Exception('Course Payment record has already been created', 400);
            }

            $this->coursePaymentServiceInterface->createNewSetCoursePayments($request->safe()->all());

            $data['message'] = 'Course Payment record was created successfully';
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
    public function update(NceCoursePaymentRequest $request, $id)
    {
        try
        {
            $coursePayment = $this->coursePaymentServiceInterface->getSetCoursePaymentById($id);

            if ($coursePayment == null)
            {
                throw new Exception('Course Payment record does not exist', 404);
            }

            $coursePayment->amount = $request->amount;
            $this->coursePaymentServiceInterface->updateSetCoursePayment($coursePayment);

            $data['message'] = 'Course Payment record was updated successfully';
            return successParser($data);
            
        }
        catch(Exception $ex){
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
            $coursePayment = $this->coursePaymentServiceInterface->getSetCoursePaymentById($id);

            if($coursePayment == null)
            {
                throw new Exception('Course Payment record does not exist', 404);
            }

            $this->coursePaymentServiceInterface->deleteSetCoursePayment($coursePayment);

            $data['message'] = 'Course Payment record was deleted successfully';
            return successParser($data);
            
        }
        catch(Exception $ex){
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
}
