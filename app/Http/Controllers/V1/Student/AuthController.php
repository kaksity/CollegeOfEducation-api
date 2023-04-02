<?php

namespace App\Http\Controllers\V1\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Student\Authentication\ChangePasswordRequest;
use App\Http\Requests\V1\Student\Authentication\RequestForgotPasswordRequest;
use App\Http\Requests\V1\Student\Authentication\LoginRequest as AuthenticationLoginRequest;
use App\Http\Requests\V1\Student\Authentication\RegisterRequest;
use App\Http\Requests\V1\Student\Authentication\VerificationForgotPassword;
use App\Mail\ForgotPassword;
use App\Models\{NceContactData, User, NcePersonalData, NceCourseData, NceApplicationStatus, NcePassport};
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    
    public function __construct(
        private User $user,
        private NcePersonalData $ncePersonalData,
        private NcePassport $ncePassport,
        private NceApplicationStatus $nceApplicationStatus,
        private NceContactData $nceContactData,
        private NceCourseData $nceCourseData)
    {}

    public function login(AuthenticationLoginRequest $request)
    {
        try
        {
            if(
                Auth::attempt(['email_address' => $request->id_number_or_email_address, 'password' => $request->password ]) == false &&
                Auth::attempt(['id_number' => $request->id_number_or_email_address, 'password' => $request->password]) == false
            )
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
                $this->ncePersonalData->create([
                    'user_id' => $user->id,
                    'surname' => $request->surname,
                    'other_names' => $request->other_names,
                ]);
                $this->nceContactData->create([
                    'user_id' => $user->id,
                    'email_address' => $request->email_address
                ]);
                $this->nceCourseData->create([
                    'user_id' => $user->id,
                ]);

                $this->nceApplicationStatus->create([
                    'user_id' => $user->id,
                    'status' => 'applying'
                ]);
                $this->ncePassport->create([
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
                Mail::to($user->email_address)->later(now()->addSeconds(5), new ForgotPassword([
                    'token' => $verificationToken,
                    'personalInformation' => $user->ncePersonalData
                ]));
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
            
            $data['message'] = 'Password was reset successfully';
            return successParser($data);
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
        $user = Auth::user();
        // Revoke all tokens...
        $user->tokens()->delete();

        $data['message'] = 'Logout';
        return successParser($data);
    }
}
