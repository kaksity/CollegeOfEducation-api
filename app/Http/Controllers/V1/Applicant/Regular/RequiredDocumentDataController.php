<?php

namespace App\Http\Controllers\V1\Applicant\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\RequiredDocumentData\RequiredDocumentDataRequest;
use App\Http\Resources\V1\Applicant\Nce\RequiredDocumentDataResource;
use App\Http\Resources\V1\RequiredDocument\RequiredDocumentResource;
use Exception;
use App\Models\NceRequiredDocumentData;
use App\Services\Interfaces\Students\RequiredDocumentDataServiceInterface;
use Illuminate\Support\Facades\Auth;

class RequiredDocumentDataController extends Controller
{
    public function __construct(private RequiredDocumentDataServiceInterface $requiredDocumentDataServiceInterface)
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requiredDocumentData = $this->requiredDocumentDataServiceInterface
                                    ->getRequiredDocumentDataByUserId(Auth::id());
       return RequiredDocumentDataResource::collection($requiredDocumentData);
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
            $hasRequiredDocumentBeenUploaded = $this->requiredDocumentDataServiceInterface
            ->checkIfRequiredDocumentHasBeenUploaded($request->required_document_id, Auth::id());
            
            if($hasRequiredDocumentBeenUploaded == true)
            {
                throw new Exception('This Required Document has already been uploaded', 400);

            }

            $extension = $request->file->getClientOriginalExtension();
            $fileNameToStore = time().uniqid().'.'.$extension;
            $request->file->storeAs('public/reqdocs', $fileNameToStore);

            $this->requiredDocumentDataServiceInterface->createNewRequiredDocumentData([
                'user_id' => Auth::id(),
                'required_document_id' => $request->required_document_id,
                'file_path' => $fileNameToStore
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
    public function destroy($id)
    {
        try
        {
            // Check if this particular user has already upload this document
            $requiredDocumentData = $this->requiredDocumentDataServiceInterface->getRequiredDocumentDataById($id);

            if ($requiredDocumentData == null)
            {
                throw new Exception('Required Document does not exist', 404);
            }

            $this->requiredDocumentDataServiceInterface->deleteRequiredDocumentData($requiredDocumentData);

            $data['message'] = 'Required Document was deleted successfully';
            return successParser($data);
        }
        catch (Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
}
