<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RequiredDocument\RequiredDocumentRequest;
use App\Http\Resources\V1\RequiredDocument\RequiredDocumentResource;
use App\Models\RequiredDocument;
use Exception;

class RequiredDocumentController extends Controller
{
    public function __construct(RequiredDocument $requiredDocument)
    {
        $this->requiredDocument = $requiredDocument;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requiredDocuments = $this->requiredDocument->latest()->get();
        return RequiredDocumentResource::collection($requiredDocuments);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequiredDocumentRequest $request)
    {
        try
        {
            $this->requiredDocument->create($request->all());
            return successParser([
                'message' => 'Required Document record was created successfully'
            ],201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequiredDocumentRequest $request, $id)
    {
        try
        {
            $requiredDocument = $this->requiredDocument->find($id);
        
            if($requiredDocument == null){
                throw new Exception('Required Document does not exist',404);
            }
            $requiredDocument->name = $request->name;
            $requiredDocument->save();

            return successParser([
                'message' => 'Required Document record was updated successfully'
            ]);
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
            $requiredDocument = $this->requiredDocument->find($id);
        
            if($requiredDocument == null){
                throw new Exception('Required Document does not exist',404);
            }

            $requiredDocument->delete();

            return successParser([
                'message' => 'Required Document record was deleted successfully'
            ]);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code); 
        }
    }
}
