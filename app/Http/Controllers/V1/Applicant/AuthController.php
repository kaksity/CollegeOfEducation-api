<?php

namespace App\Http\Controllers\V1\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\Authentication\LoginRequest;
use App\Http\Requests\V1\Applicant\Authentication\RegisterRequest;
use App\Models\{NceAcademicSession, NceContactData, User, NcePersonalData, NceCourseData, NceApplicationStatus, NcePassport, NceExaminationCenterData};
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\V1\Applicant\Authentication\RequestForgotPasswordRequest;
use App\Http\Requests\V1\Applicant\Authentication\VerificationForgotPassword;

class AuthController extends Controller
{
    
    public function __construct(User $user, NcePersonalData $NcePersonalData, NcePassport $NcePassport,NceApplicationStatus $NceApplicationStatus,NceContactData $NceContactData, NceCourseData $NceCourseData, NceExaminationCenterData $NceExaminationCenterData, NceAcademicSession $nceAcademicSession)
    {
        $this->user = $user;
        $this->NcePersonalData = $NcePersonalData;
        $this->NceContactData = $NceContactData;
        $this->NceCourseData = $NceCourseData;
        $this->NceApplicationStatus = $NceApplicationStatus;
        $this->NcePassport = $NcePassport;
        $this->NceExaminationCenterData = $NceExaminationCenterData;
        $this->nceAcademicSession = $nceAcademicSession;
    }
    public function login(LoginRequest $request)
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
            
            if($user->ncePersonalData()->exists() == false || $user->nceContactData()->exists() == false)
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
            // Check if the email_address already exist
            $user = $this->user->where('email_address', $request->email_address)->first();
            
            if($user != null)
            {
                throw new Exception('Email Address has already been taken',400);
            }

            $currentSession = $this->nceAcademicSession->getCurrentSession($request->course_group_id);
            if($currentSession == null)
            {
                throw new Exception('Current Session has not been set by the admin',400);
            }
            DB::beginTransaction();
            try
            {
                $user = $this->user->create([
                    'email_address' => $request->email_address,
                    'password' => Hash::make($request->password),
                ]);
                $this->NcePersonalData->create([
                    'user_id' => $user->id,
                    'surname' => $request->surname,
                    'other_names' => $request->other_names,
                    'state_id' => $request->state_id
                ]);
                $this->NceContactData->create([
                    'user_id' => $user->id,
                    'email_address' => $request->email_address
                ]);
                $this->NceCourseData->create([
                    'user_id' => $user->id,
                    'course_group_id' => $request->course_group_id
                ]);

                $this->NceApplicationStatus->create([
                    'user_id' => $user->id,
                    'status' => 'applying',
                    'is_new_applicant' => true,
                    'academic_session_id' => $currentSession->id 
                ]);
                $this->NcePassport->create([
                    'user_id' => $user->id
                ]);
                $this->NceExaminationCenterData->create([
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
    public function requestPasswordVerification(RequestForgotPasswordRequest $request)
    {
        try
        {
            $user = $this->user->where([
                'email_address' => $request->email_address
            ])->first();

            if($user)
            {
                $verificationToken = generateRandomNumber();
                
                DB::table('password_resets')->where([
                    'email' => $request->email_address,
                ])->delete();

                DB::table('password_resets')->insert([
                    'email' => $request->email_address,
                    'token' => $verificationToken,
                    'created_at' => Carbon::now()
                ]);

                //Send a Mail
            }

            $data['message'] = 'Password reset instruction has been sent to this mail';
            return successParser($data);
        }
        
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();

            return errorParser($data, $code);
        }
    }
    public function verifyPasswordVerificationCode(VerificationForgotPassword $request)
    {
        try
        {
            $verificationCode = DB::table('password_resets')->select('*')->where([
                'email' => $request->email_address,
                'token' => $request->verification_code,
            ])->first();

            if($verificationCode == null)
            {
                throw new Exception('Verification code does not exist', 404);
            }
            $hashPassword = Hash::make($request->new_password);
            
            DB::table('users')->where([
                'email_address' => $request->email_address
            ])->update([
                'password' => $hashPassword
            ]);
            
            $data['message'] = 'Password reset instruction has been sent to this mail';
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