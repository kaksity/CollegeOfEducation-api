<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\ContactData\ContactDataRequest;
use App\Http\Resources\V1\Applicant\Nce\ContactDataResource;
use Exception;
use App\Models\{NceContactData};
use App\Services\Interfaces\Students\ContactDataServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactDataController extends Controller
{
    public function __construct(private ContactDataServiceInterface $contactDataServiceInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactData = $this->contactDataServiceInterface->getContactDataByUserId(Auth::user()->id);
        return new ContactDataResource($contactData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactDataRequest $request, $id)
    {
        try
        {
            $contactData = $this->contactDataServiceInterface->getContactDataByUserId(Auth::user()->id);
            
            if ($contactData->id != $id)
            {
                throw new Exception('You can only update your data', 400);
            }

            $contactData->name_of_guardian = $request->name_of_guardian;
            $contactData->address_of_guardian = $request->address_of_guardian;
            $contactData->name_of_employer = $request->name_of_employer;
            $contactData->address_of_employer = $request->address_of_employer;
            $contactData->contact_address = $request->contact_address;
            $contactData->phone_number = $request->phone_number;

            $this->contactDataServiceInterface->updateContactData($contactData);

            $data['message'] = 'Applicant contact data was updated successfully';
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
