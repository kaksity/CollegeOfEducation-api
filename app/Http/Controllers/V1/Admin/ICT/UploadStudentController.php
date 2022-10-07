<?php
namespace App\Http\Controllers\V1\Admin\ICT;
use App\Models\NceApplicationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\ICT\UploadStudentRequest;
use App\Http\Resources\V1\Admin\ICT\UploadStudentResource;
use App\Models\User;
use Exception;

class UploadStudentController extends Controller
{
    public function __construct(NceApplicationStatus $nceApplicationStatus, User $user)
    {
        $this->nceApplicationStatus = $nceApplicationStatus;
        $this->user = $user;
    }
    public function index(UploadStudentRequest $request)
    {
        try
        {
            $student = $this->nceApplicationStatus->where([
                'admission_number' => $request->application_tracking_number,
                'status' => 'admitted'
            ])->first();
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
            $student = $this->user->find($id);

            if($student == null)
            {
                throw new Exception('Student record does not exist', 404);
            }
            
            if($student->id_number != null || $student->id_number != '' )
            {
                throw new Exception('Student ID Number has already been set', 400);
            }

            $student->update([
                'id_number' => $request->id_number
            ]);
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