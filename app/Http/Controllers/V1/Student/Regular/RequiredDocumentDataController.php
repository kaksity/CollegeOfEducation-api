<?php

namespace App\Http\Controllers\V1\Student\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\RequiredDocumentData\RequiredDocumentDataRequest;
use App\Http\Resources\V1\Applicant\Nce\RequiredDocumentDataResource;
use App\Http\Resources\V1\RequiredDocument\RequiredDocumentResource;
use Exception;
use App\Models\NceRequiredDocumentData;
use Illuminate\Support\Facades\Auth;

class RequiredDocumentDataController extends Controller
{
    public function __construct(NceRequiredDocumentData $nceRequiredDocumentData )
    {
        $this->nceRequiredDocumentData = $nceRequiredDocumentData;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $nceRequiredDocumentData = $this->nceRequiredDocumentData->with(['requiredDocument'])->where([
        'user_id' => Auth::id(),
       ])->get();

       return RequiredDocumentDataResource::collection($nceRequiredDocumentData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequiredDocumentDataRequest $request)
    {
        try
        {
            // Check if this particular user has already upload this document
            $uploadedNceRequiredDocument = $this->nceRequiredDocumentData->where([
                'user_id' => Auth::id(),
                'required_document_id' => $request->required_document_id
            ])->first();

            if($uploadedNceRequiredDocument != null)
            {
                throw new Exception('This Required Document has already been uploaded', 400);
            }

            //uniqid()                  
            $extention = $request->file->getClientOriginalExtension();      
            $fileNameToStore = time().uniqid().'.'.$extention;
            
            $path = $request->file->storeAs('public/reqdocs', $fileNameToStore);

            $this->nceRequiredDocumentData->create([
                'user_id' => Auth::id(),
                'required_document_id' => $request->required_document_id,
                'file_path' => $path
            ]);
            $data['message'] = 'Required Document was uploaded successfully';
            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
    public function destory($id)
    {
        try
        {
            // Check if this particular user has already upload this document
            $uploadedNceRequiredDocument = $this->nceRequiredDocumentData->find($id);

            if($uploadedNceRequiredDocument == null)
            {
                throw new Exception('Required Document does not exist', 404);
            }

            $uploadedNceRequiredDocument->delete();
            $data['message'] = 'Required Document was deleted successfully';
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
