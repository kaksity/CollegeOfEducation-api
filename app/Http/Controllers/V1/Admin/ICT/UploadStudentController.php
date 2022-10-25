<?php
namespace App\Http\Controllers\V1\Admin\ICT;
use App\Models\NceApplicationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\ICT\UploadStudentRequest;
use App\Http\Resources\V1\Admin\ICT\UploadStudentResource;
use App\Models\User;
use App\Services\Interfaces\Students\StudentServiceInterface;
use Exception;

class UploadStudentController extends Controller
{
    public function __construct(private StudentServiceInterface $studentServiceInterface)
    {}
    public function index(UploadStudentRequest $request)
    {
        try
        {
            $student = $this->studentServiceInterface
                            ->getStudentByTrackingNumber($request->application_tracking_number);
            if($student == null)
            {
                throw new Exception('Student record does not exist', 404);
            }
            return new UploadStudentResource($student);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
    public function update(UploadStudentRequest $request, $id)
    {
        try
        {
            $student = $this->studentServiceInterface->getStudentById($id);

            if($student == null)
            {
                throw new Exception('Student record does not exist', 404);
            }
            
            if($student->id_number != null || $student->id_number != '' )
            {
                throw new Exception('Student ID Number has already been set', 400);
            }

            $student->id_number = $request->id_number;
            
            $this->studentServiceInterface->uploadNewStudent($student);
            
            $data['message'] = 'Student ID Number has been set successfully';
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
