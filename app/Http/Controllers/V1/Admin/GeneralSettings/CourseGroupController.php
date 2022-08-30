<?php

namespace App\Http\Controllers\V1\Admin\GeneralSettings;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Course\CourseResource;
use App\Models\CourseGroup;
use Exception;
use Illuminate\Http\Request;

class CourseGroupController extends Controller
{
    public function __construct(CourseGroup $courseGroup)
    {
        $this->courseGroup = $courseGroup;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courseGroups = $this->courseGroup->orderBy('name', 'ASC')->get();
        return CourseResource::collection($courseGroups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $courseGroup = $this->courseGroup->find($request->name);
            if($courseGroup != null)
            {
                throw new Exception('Course group record does not exit',404);
            }

            $this->courseGroup->create([
                'code' => $request->code,
                'name' => $request->name
            ]);

            $data['message'] = 'Course group record was created successfully';
            return successParser($data);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
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
            $courseGroup = $this->courseGroup->find($id);
            if($courseGroup == null)
            {
                throw new Exception('Course group record does not exit',404);
            }

            $courseGroup->delete();

            $data['message'] = 'Course group record was deleted successfully';
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
