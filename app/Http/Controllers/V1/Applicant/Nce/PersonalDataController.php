<?php

namespace App\Http\Controllers\V1\Applicant\Nce;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\PersonalData\PersonalDataRequest;
use App\Http\Resources\V1\Applicant\Nce\PersonalDataResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{State, Lga, MaritalStatus};
class PersonalDataController extends Controller
{
    public function __construct(State $state, Lga $lga, MaritalStatus $maritalStatus)
    {
        $this->state = $state;
        $this->lga = $lga;
        $this->maritalStatus = $maritalStatus;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personalData = Auth::user()->ncePersonalData()->with(['maritalStatus','lga','state'])->first();
        // dd($personalData);
        return new PersonalDataResource($personalData);
    }

    public function update(PersonalDataRequest $request, $id)
    {
        try
        {
            if($this->state->find($request->state_id) == null)
            {
                throw new Exception('State record does not exist', 400);
            }
            if($this->lga->find($request->lga_id) == null)
            {
                throw new Exception('Lga record does not exist',400);
            }
            if($this->maritalStatus->find($request->marital_status_id) == null)
            {
                throw new Exception('Marital Status record does not exist');
            }

            $personalData = Auth::user()->ncePersonalData()->first();

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
            $personalData->save();
            $data['message'] = 'Applicant personal data was updated successfully';
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
