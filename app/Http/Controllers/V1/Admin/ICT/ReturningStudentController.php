<?php

namespace App\Http\Controllers\V1\Admin\ICT;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\ICT\ReturningStudentRequest;
use App\Services\Interfaces\GeneralSettings\AcademicSessionServiceInterface;
use App\Services\Interfaces\Students\StudentServiceInterface;
use Exception;

class ReturningStudentController extends Controller
{
    public function __construct(
        private StudentServiceInterface $studentServiceInterface,
        private AcademicSessionServiceInterface $academicSessionServiceInterface
    )
    {}

    public function store(ReturningStudentRequest $request)
    {
        try
        {
            // Check if the email_address already exist
            $user = $this->studentServiceInterface->getStudentByEmailAddress($request->email_address);

            if($user != null)
            {
                throw new Exception('Student Email has already been registered',400);
            }
            
            $user = $this->studentServiceInterface->getStudentByIDNumber($request->id_number);

            if($user != null)
            {
                throw new Exception('Student ID has already been registered',400);
            }

            $currentSession = $this->academicSessionServiceInterface
                                    ->getCurrentSessionByCourseGroupId($request->course_group_id);
            if($currentSession == null)
            {
                throw new Exception('Current Session has not been set by the admin',400);
            }

            $this->studentServiceInterface->createReturningStudent($request->safe()->all());
            $data['message'] = 'Returning Students was created successfully';
            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();

            return errorParser($data,$code);
        }
    }
}
