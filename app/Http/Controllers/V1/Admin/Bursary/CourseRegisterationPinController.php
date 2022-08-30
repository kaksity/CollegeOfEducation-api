<?php

namespace App\Http\Controllers\V1\Admin\Bursary;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Bursary\CourseRegisterationPin\CourseRegisterationPinRequest;
use App\Http\Resources\V1\Admin\Bursary\CourseRegisterationPinResource;
use App\Models\CourseRegisterationCard;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseRegisterationPinController extends Controller
{
    public function __construct(CourseRegisterationCard $courseRegisterationCard)
    {
        $this->courseRegisterationCard = $courseRegisterationCard;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CourseRegisterationPinRequest $request)
    {
        $perPage = $request->per_page ?? 500;

        $courseRegisterationCards = $this->courseRegisterationCard->with(['academicSession', 'courseGroup'])->latest()->paginate($perPage);
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
            $courseRegisterationCard = $this->courseRegisterationCard->where([
                'academic_session_id' => $request->academic_session_id,
                'course_group_id' => $request->course_group_id
            ])->first();

            if($courseRegisterationCard)
            {
                throw new Exception('Card for this course group and academic session has been generated', 400);
            }
            DB::beginTransaction();

            for($i=0; $i < $request->number_of_cards; $i++)
            {
                
                $serialNumber = generateRandomNumber().generateRandomNumber().generateRandomNumber().generateRandomNumber();
                $pin = generateRandomNumber().generateRandomString().generateRandomNumber().generateRandomString();

                $this->courseRegisterationCard->create([
                    'academic_session_id' => $request->academic_session_id,
                    'course_group_id' => $request->course_group_id,
                    'serial_number' => $serialNumber,
                    'used_counter' => 0,
                    'status' => 'active',
                    'pin' => $pin
                ]);
            }
            DB::commit();

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
            $courseRegisterationCard = $this->courseRegisterationCard->find($id);

            if($courseRegisterationCard == null)
            {
                throw new Exception('Course registeration card does not exist', 404);
            }

            $courseRegisterationCard->update([
                'status' => $request->status
            ]);
            $data['message'] = 'Course registeration card has been generated successfully';
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
