<?php

namespace App\Http\Controllers\V1\Admin\ICT;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\ICT\StudentCollectionResource;
use App\Http\Resources\V1\Admin\ICT\StudentResource;
use App\Models\User;
use App\Services\Interfaces\Students\StudentServiceInterface;
use Exception;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function __construct(private StudentServiceInterface $studentServiceInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 100;


        $emailAddressOrIdNumber = $request->emai_address_or_id_number ?? null;

        $students = [];
        if ($emailAddressOrIdNumber == null)
        {
            $students = $this->studentServiceInterface->getAllAdmittedStudents($perPage);
        }
        else
        {
            $students = $this->studentServiceInterface->searchStudentByEmailAddressOrIdNumber($emailAddressOrIdNumber);
        }
        return StudentCollectionResource::collection($students);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $student = $this->studentServiceInterface->getStudentById($id);

            if($student == null)
            {
                throw new Exception('Student record does not exist', 404);
            }

            return new StudentResource($student);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
}
