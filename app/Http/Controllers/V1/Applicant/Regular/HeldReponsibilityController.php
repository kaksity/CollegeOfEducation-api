<?php

namespace App\Http\Controllers\V1\Applicant\Regular;
use App\Services\Interfaces\Students\HeldResponsibilityDataServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\HeldResponsibilityData\HeldResponsibilityDataRequest;
use App\Http\Resources\V1\Applicant\Nce\HeldResponsibilityDataResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HeldReponsibilityController extends Controller
{
    public function __construct(private HeldResponsibilityDataServiceInterface $heldResponsibilityDataServiceInterface)
    {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HeldResponsibilityDataRequest $request)
    {
        $perPage = $request->per_page ?? 10;
        
        $heldResponsibilities = $this->heldResponsibilityDataServiceInterface
                                        ->getHeldResponsibilityByUserId(Auth::id(), $perPage);
        
        return HeldResponsibilityDataResource::collection($heldResponsibilities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HeldResponsibilityDataRequest $request)
    {
        try
        {
            
            $this->heldResponsibilityDataServiceInterface->createNewHeldResponsibility(
                array_merge($request->safe()->all(), [
                'user_id' => Auth::id()
            ]));

            $data['message'] = 'Applicant held responsibility data was added successfully';
            return successParser($data,201);
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
            $heldResponsibility = $this->heldResponsibilityDataServiceInterface->getHeldResponsibilityById($id);
            
            if($heldResponsibility == null)
            {
                throw new Exception('Applicant held Responsibility does not exist',404);
            }

            $this->heldResponsibilityDataServiceInterface->deleteHeldResponsibility($heldResponsibility);

            $data['message'] = 'Applicant held responsibility data was deleted successfully';
            return successParser($data);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code);
        }
    }
}
