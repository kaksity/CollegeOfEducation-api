<?php

namespace App\Http\Controllers\V1\Applicant;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Applicant\Authentication\ChangePasswordRequest;
use App\Http\Requests\V1\Applicant\Authentication\LoginRequest;
use App\Http\Requests\V1\Applicant\Authentication\RegisterRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\V1\Applicant\Authentication\RequestForgotPasswordRequest;
use App\Http\Requests\V1\Applicant\Authentication\VerificationForgotPassword;
use App\Services\Interfaces\General\AuthenticationServiceInterface;
use App\Services\Interfaces\Students\StudentServiceInterface;

class AuthController extends Controller
{
    public function __construct(
        private StudentServiceInterface $studentServiceInterface,
        private AuthenticationServiceInterface $authenticationServiceInterface
    )
    {}
    
    public function login(LoginRequest $request)
    {
        try
        {
            
            $data['access_token'] = $this->authenticationServiceInterface->login($request->safe()->all());
            $data['message'] = 'Login was successfully.';
            return successParser($data);
        }
        catch (Exception $ex)
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
            $user = $this->studentServiceInterface->getStudentByEmailAddress($request->email_address);
            
            if($user != null)
            {
                throw new Exception('Email Address has already been taken', 400);
            }

            $this->studentServiceInterface->createNewStudent($request->safe()->all());

            $data['message'] = 'Applicant account was created successfully';
            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();

            return errorParser($data, $code);
        }
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        try
        {
            $user = Auth::user();

            if(Hash::check($request->old_password, $user->password) == false)
            {
                throw new Exception('Old Password is not correct', 400);
            }

            $hashedPassword = Hash::make($request->new_password);
            
            $user->update([
                'password' => $hashedPassword
            ]);
            $data['message'] = 'Password was changed successfully';
            
            return successParser($data, 201);
        }
        catch(Exception $ex)
        {
            $data['message'] = $ex->getMessage();
            $code = $ex->getCode();
            return errorParser($data, $code);
        }
    }
    public function logout()
    {
        $this->authenticationServiceInterface->logout();

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
