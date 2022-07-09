<?php

namespace App\Http\Controllers\V1\Student\Nce;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Student\ContactData\ContactDataRequest;
use App\Http\Resources\V1\Student\ContactDataResource;
use Exception;
use App\Models\{DipContactData};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactDataController extends Controller
{
    public function __construct(DipContactData $dipContactData)
    {
        $this->dipContactData = $dipContactData;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact = Auth::user()->dipContactData()->first();
        return new ContactDataResource($contact);
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
            $contactData = Auth::user()->dipContactData()->first();
            
            if($contactData->id != $id)
            {
                throw new Exception('You can only update your data', 400);
            }
            $contactDataByEmail = $this->dipContactData->where('email_address',$request->email_address)->first();

            // if($contactDataByEmail != null)
            // {
            //     throw new Exception('Email Address already exist in our database',400);
            // }

            $contactData->name_of_guardian = $request->name_of_guardian;
            $contactData->address_of_guardian = $request->address_of_guardian;
            $contactData->name_of_employer = $request->name_of_employer;
            $contactData->address_of_employer = $request->address_of_employer;
            $contactData->contact_address = $request->contact_address;
            // $contactData->email_address = $request->email_address;
            $contactData->phone_number = $request->phone_number;

            $contactData->save();

            $data['message'] = 'Student contact data was updated successfully';
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
