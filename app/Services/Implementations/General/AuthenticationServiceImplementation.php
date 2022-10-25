<?php

namespace App\Services\Implementations\General;

use App\Services\Interfaces\General\AuthenticationServiceInterface;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthenticationServiceImplementation implements AuthenticationServiceInterface
{
    public function login(array $data)
    {
        if(Auth::attempt(['email_address' => $data['email_address'], 'password' => $data['password']]) == false)
            {
                throw new Exception("Email Address or Password is not correct", 400);
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

            return $accessToken;
    }
    public function logout()
    {
        Auth::tokens()->delete();
    }
}
