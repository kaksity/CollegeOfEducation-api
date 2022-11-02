<?php

namespace App\Http\Controllers\V1\Student\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Student\PersonalData\PersonalDataRequest;
use App\Http\Resources\V1\Student\Nce\PersonalDataResource;
use App\Services\Interfaces\GeneralSettings\LgaServiceInterface;
use App\Services\Interfaces\GeneralSettings\MaritalStatusInterface;
use App\Services\Interfaces\GeneralSettings\StateServiceInterface;
use App\Services\Interfaces\Students\PersonalDataServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalDataController extends Controller
{
    public function __construct(
        private StateServiceInterface $stateServiceInterface,
        private LgaServiceInterface $lgaServiceInterface,
        private MaritalStatusInterface $maritalStatusInterface,
        private PersonalDataServiceInterface $personalDataServiceInterface
    )
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personalData = $this->personalDataServiceInterface->getPersonalDataByUserId(Auth::user()->id);
        return new PersonalDataResource($personalData);
    }

    public function update(PersonalDataRequest $request, $id)
    {
        try
        {
            if ($this->stateServiceInterface->getStateById($request->state_id) == null)
            {
                throw new Exception('State record does not exist', 400);
            }
            if ($this->lgaServiceInterface->getLgaById($request->lga_id) == null)
            {
                throw new Exception('Lga record does not exist',400);
            }
            if ($this->maritalStatusInterface->getMaritalStatusById($request->marital_status_id) == null)
            {
                throw new Exception('Marital Status record does not exist');
            }



            $personalData = $this->personalDataServiceInterface->getPersonalDataByUserId(Auth::user()->id);
            
            if($personalData->id != $id)
            {
                throw new Exception('You can only update your data', 400);
            }
            
            $personalData->surname = $request->surname;
            $personalData->other_names = $request->other_names;
            $personalData->date_of_birth = $request->date_of_birth;
            $personalData->place_of_birth = $request->place_of_birth;
            $personalData->sex = $request->sex;
            $personalData->marital_status_id = $request->marital_status_id;
            $personalData->home_town = $request->home_town;
            $personalData->state_id = $request->state_id;
            $personalData->lga_id = $request->lga_id;
            $personalData->nationality = $request->nationality;
            
            $this->personalDataServiceInterface->updatePersonalData($personalData);
            
            $data['message'] = 'Student personal data was updated successfully';
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
