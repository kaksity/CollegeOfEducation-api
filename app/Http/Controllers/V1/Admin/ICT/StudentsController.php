<?php

namespace App\Http\Controllers\V1\Admin\ICT;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\ICT\StudentCollectionResource;
use App\Http\Resources\V1\Admin\ICT\StudentResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 100;
        $emailAddressOrIdNumber = $request->emai_address_or_id_number ?? null;

        $students = $this->user->where('role', 'student')
            ->with([
                'ncePersonalData',
                'nceCourseData'
            ])->when($emailAddressOrIdNumber, function($model) use($emailAddressOrIdNumber) {
                $model->where('id_number', 'like', $emailAddressOrIdNumber.'%')
                    ->orWhere('email_address', 'like', $emailAddressOrIdNumber.'%');
            })
            ->whereHas('nceApplicationStatus', fn($model) => $model->where([
                'status' => 'admitted',
            ]))->latest()->paginate($perPage);
        return StudentCollectionResource::collection($students);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $student = $this->user->where([
                'id' => $id,
                'role' => 'student'
            ])->first();

            if($student == null)
            {
                throw new Exception('Student record does not exist', 404);
            }

            return new StudentResource($student);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
