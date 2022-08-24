<?php

namespace App\Http\Controllers\V1\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\Authentication\LoginRequest as AuthenticationLoginRequest;
use App\Http\Requests\V1\Student\Authentication\RegisterRequest;
use App\Models\{NceContactData, User, NcePersonalData, NceCourseData, NceApplicationStatus, NcePassport};
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function __construct(User $user, NcePersonalData $NcePersonalData, NcePassport $NcePassport,NceApplicationStatus $NceApplicationStatus,NceContactData $NceContactData, NceCourseData $NceCourseData)
    {
        $this->user = $user;
        $this->NcePersonalData = $NcePersonalData;
        $this->NceContactData = $NceContactData;
        $this->NceCourseData = $NceCourseData;
        $this->NceApplicationStatus = $NceApplicationStatus;
        $this->NcePassport = $NcePassport;
    }
    public function login(AuthenticationLoginRequest $request)
    {
        try
        {
            if(Auth::attempt(['email_address' => $request->email_address, 'password' => $request->password ]) == false)
            {
                throw new Exception("Email Address or Password is not correct",400);
            }

            $user = Auth::user();

            if($user->is_enabled == false)
            {
                throw new Exception("Account has been disabled",400);
            }
            if($user->nceApplicationStatus()->first()->status != 'admitted'){
                throw new Exception("Email Address or Password is not correct",400);
            }
            if($user->ncePersonalData()->exists() == false || $user->nceContactData()->exists() == false)
            {
                throw new Exception('Sorry, Access Denied', 401);
            }
            
            $accessToken = $user->createToken('Access Token')->plainTextToken;

            $user->update([
                'last_login_at' => now()
            ]);

            $data['access_token'] = $accessToken;
            $data['message'] = 'Login was succesful.';
            return successParser($data);
        }   
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data,$code);
        }
    }

    public function register(RegisterRequest $request)
    {
        try
        {
            // Check if the email_address already exist
            $user = $this->user->where('email_address', $request->email_address)->first();
            
            if($user != null)
            {
                throw new Exception('Email Address has already been taken',400);
            }

            DB::beginTransaction();
            try
            {
                $user = $this->user->create([
                    'email_address' => $request->email_address,
                    'password' => Hash::make($request->password)
                ]);
                $this->NcePersonalData->create([
                    'user_id' => $user->id,
                    'surname' => $request->surname,
                    'other_names' => $request->other_names,
                ]);
                $this->NceContactData->create([
                    'user_id' => $user->id,
                    'email_address' => $request->email_address
                ]);
                $this->NceCourseData->create([
                    'user_id' => $user->id,
                ]);

                $this->NceApplicationStatus->create([
                    'user_id' => $user->id,
                    'status' => 'applying'
                ]);
                $this->NcePassport->create([
                    'user_id' => $user->id
                ]);
                DB::commit();
                
                $data['message'] = 'Student account was created successfully';
                return successParser($data,201);

            }
            catch(Exception $ex)
            {
                DB::rollBack();
                $data['message'] = $ex->getMessage();
                $code = $ex->getCode();
                return errorParser($data,$code);
            }
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();

            return errorParser($data,$code);
        }
    }

    public function logout()
    {
        $user = Auth::user();
        // Revoke all tokens...
        $user->tokens()->delete();

        $data['message'] = 'Logout';
        return successParser($data);
    }
}
