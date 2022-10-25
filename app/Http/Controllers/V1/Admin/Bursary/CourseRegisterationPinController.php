<?php

namespace App\Http\Controllers\V1\Admin\Bursary;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Bursary\CourseRegisterationPin\CourseRegisterationPinRequest;
use App\Http\Resources\V1\Admin\Bursary\CourseRegisterationPinResource;
use App\Services\Interfaces\Bursary\CourseRegistrationCardServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseRegisterationPinController extends Controller
{
    public function __construct(private CourseRegistrationCardServiceInterface $courseRegistrationCardServiceInterface)
    {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CourseRegisterationPinRequest $request)
    {
        $perPage = $request->per_page ?? 500;

        $courseRegisterationCards = $this->courseRegistrationCardServiceInterface
                                            ->getAllCourseRegistrationCard($perPage);
        return CourseRegisterationPinResource::collection($courseRegisterationCards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRegisterationPinRequest $request)
    {
        try
        {
            $this->courseRegistrationCardServiceInterface
                ->createNewCourseRegistrationCards($request->safe()->all());

            // $this->courseRegisterationCard->create($request->safe()->all());
            $data['message'] = 'Course registeration card has been generated successfully';
            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            DB::rollBack();
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
            $courseRegistrationCard = $this->courseRegistrationCardServiceInterface
                                            ->getCourseRegistrationCardById($id);

            if($courseRegistrationCard == null)
            {
                throw new Exception('Course registration card does not exist', 404);
            }

            $courseRegistrationCard->status = $request->status;
            $this->courseRegistrationCardServiceInterface->updateCourseRegistrationCard($courseRegistrationCard);

            $data['message'] = 'Course registration card has been generated successfully';
            return successParser($data, 200);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
}
