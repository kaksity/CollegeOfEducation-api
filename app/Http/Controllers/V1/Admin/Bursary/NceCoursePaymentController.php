<?php

namespace App\Http\Controllers\V1\Admin\Bursary;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Bursary\NceCoursePayment\NceCoursePaymentRequest;
use App\Http\Resources\V1\Admin\Bursary\NceCoursePaymentResource;
use Exception;
use Illuminate\Http\Request;
use App\Models\{ NceCoursePayment, Course };

class NceCoursePaymentController extends Controller
{
    public function __construct(NceCoursePayment $nceCoursePayment, Course $course)
    {
        $this->nceCoursePayment = $nceCoursePayment;
        $this->course = $course;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NceCoursePaymentRequest $request)
    {
        $perPage = $request->per_page ?? 20;
        $nceCoursePayments = $this->nceCoursePayment->with(['nceCourse'])->latest()->paginate($perPage);
        return NceCoursePaymentResource::collection($nceCoursePayments);
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
            $course = $this->course->find($request->course_id);

            if($course == null)
            {
                throw new Exception('Course Record does not exist', 404);
            }

            $nceCoursePayment = $this->nceCoursePayment->where([
                'course_id' => $request->course_id,
                'is_indigine' => $request->is_indigine,
                'year_group' => $request->year_group
            ])->first();
            
            if($nceCoursePayment != null)
            {
                throw new Exception('Nce Course Payment record has already been created', 400);
            }
            $this->nceCoursePayment->create([
                'course_id' => $request->course_id,
                'amount' => $request->amount,
                'year_group' => $request->year_group,
                'is_indigine' => $request->is_indigine
            ]);

            $data['message'] = 'Nce Course Payment record was created successfully';
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
            $nceCoursePayment = $this->nceCoursePayment->find($id);

            if($nceCoursePayment == null)
            {
                throw new Exception('Nce Course Payment record does not exist', 404);
            }

            $nceCoursePayment->amount = $request->amount;
            $nceCoursePayment->save();

            $data['message'] = 'Nce Course Payment record was updated successfully';
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
            $nceCoursePayment = $this->nceCoursePayment->find($id);

            if($nceCoursePayment == null)
            {
                throw new Exception('Nce Course Payment record does not exist', 404);
            }

            $nceCoursePayment->delete();

            $data['message'] = 'Nce Course Payment record was deleted successfully';
            return successParser($data);
            
        }
        catch(Exception $ex){
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
}
