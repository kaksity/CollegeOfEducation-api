<?php

namespace App\Http\Controllers\V1\Student\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\EmploymentData\EmploymentDataRequest;
use App\Http\Resources\V1\Applicant\Nce\EmploymentDataResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\Students\EmploymentDataServiceInterface;

class EmploymentDataController extends Controller
{
    public function __construct(private EmploymentDataServiceInterface $employmentDataServiceInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EmploymentDataRequest $request)
    {
        $employmentData = $this->employmentDataServiceInterface
                                ->getEmploymentDataByUserId(Auth::id(), $request->per_page);
        return EmploymentDataResource::collection($employmentData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmploymentDataRequest $request)
    {
        try
        {
            $this->employmentDataServiceInterface->createNewEmploymentData(array_merge(
                $request->safe()->all(), [
                    'user_id' => Auth::id()
                ]
                ));
            $data['message'] = 'Student employment data was created successfully';
            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code);
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
            $employmentData = $this->employmentDataServiceInterface->getEmploymentDataById($id);
            
            if($employmentData == null)
            {
                throw new Exception('Student employment data does not exist', 404);
            }

            $this->employmentDataServiceInterface->deleteEmploymentData($employmentData);

            $data['message'] = 'Student employment data was deleted successfully';
            return successParser($data);
        }
        catch (Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code);
        }
    }
}
