<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Http\Resources\V1\Admin\AdminResource;
use Exception;
use App\Models\{User, Admin};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(User $user, Admin $admin)
    {
        $this->user = $user;
        $this->admin = $admin;

    }
    public function login(LoginRequest $request)
    {
        try
        {
            if(Auth::attempt([
                'email_address' => $request->email_address,
                'password' => $request->password
            ]) == false)
            {
                throw new Exception("Email Address or Password is not correct",400);
            }

            $user = Auth::user();

            if($user->is_enabled == false)
            {
                throw new Exception("Account has been disabled",400);
            }
            
            if($user->admin()->exists() == false)
            {
                throw new Exception('Sorry, Access Denied',401);
            }

            // if ($user->last_login_at === null):
            //     $reset_code = generateRandomNumber();

            //     DB::table('password_resets')->insert([
            //         'user_id' => $user->id,
            //         'email' => $user['staff']['email'],
            //         'token' => $reset_code,
            //         'created_at' => now()
            //     ]);

            //     $data['reset_code'] = $reset_code;
            //     $data['required_new_password'] = true;
            //     $data['message'] = 'Please change your current password.';
            //     return successParser($data);
            // endif;

            $accessToken = $user->createToken('Access Token')->plainTextToken;

            $user->update([
                'last_login_at' => now()
            ]);

            $data['access_token'] = $accessToken;
            $data['user'] = new AdminResource(Auth::user());
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
            $user = $this->user->where([
                'email_address' => $request->email_address
            ])->first();       
            if($user != null)
            {
                throw new Exception('Email Address has already been used', 400);
            }
            DB::beginTransaction();
            $user = $this->user->create([
                'email_address' => $request->email_address,
                'role' => $request->role,
                'password' => Hash::make($request->password)
            ]);
            $admin = $this->admin->create([
                'user_id' => $user->id,
                'email_address' => $request->email_address,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'middle_name' => $request->middle_name
            ]);
            DB::commit();
            return successParser([
                'message' => 'Admin account was created successfully'
            ],201);
        }
        catch(Exception $ex)
        {
            DB::rollBack();
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
