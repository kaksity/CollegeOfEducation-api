<?php

namespace App\Http\Controllers\V1\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\Authentication\LoginRequest;
use App\Http\Requests\V1\Applicant\Authentication\RegisterRequest;
use App\Models\{DipContactData, User, DipPersonalData, DipCourseData, DipApplicationStatus, DipPassport};
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function __construct(User $user, DipPersonalData $dipPersonalData, DipPassport $dipPassport,DipApplicationStatus $dipApplicationStatus,DipContactData $dipContactData, DipCourseData $dipCourseData)
    {
        $this->user = $user;
        $this->dipPersonalData = $dipPersonalData;
        $this->dipContactData = $dipContactData;
        $this->dipCourseData = $dipCourseData;
        $this->dipApplicationStatus = $dipApplicationStatus;
        $this->dipPassport = $dipPassport;
    }
    public function login(LoginRequest $request)
    {
        try
        {
            if(Auth::attempt(['username' => $request->username, 'password' => $request->password ]) == false)
            {
                throw new Exception("Username or Password is not correct",400);
            }

            $user = Auth::user();

            if($user->is_enabled == false)
            {
                throw new Exception("Account has been disabled",400);
            }
            
            if($user->dipPersonalData()->exists() == false || $user->dipContactData()->exists() == false)
            {
                throw new Exception('Sorry, Access Denied', 401);
            }

            $accessToken = $user->createToken('Access Token')->plainTextToken;

            $user->update([
                'last_login_at' => now()
            ]);

            $data['access_token'] = $accessToken;
            // $data['user'] = new AdminResource(Auth::user());
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
            // Check if the username already exist
            $user = $this->user->where('username', $request->username)->first();
            
            if($user != null)
            {
                throw new Exception('Username has already been taken',400);
            }

            DB::beginTransaction();
            try
            {
                $user = $this->user->create([
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                ]);
                $this->dipPersonalData->create([
                    'user_id' => $user->id,
                    'surname' => $request->surname,
                    'other_names' => $request->other_names,
                ]);
                $this->dipContactData->create([
                    'user_id' => $user->id,
                    'email_address' => $request->email_address
                ]);
                $this->dipCourseData->create([
                    'user_id' => $user->id,
                ]);

                $this->dipApplicationStatus->create([
                    'user_id' => $user->id,
                    'status' => 'applying'
                ]);
                $this->dipPassport->create([
                    'user_id' => $user->id
                ]);
                DB::commit();
                
                $data['message'] = 'Applicant account was created successfully';
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
