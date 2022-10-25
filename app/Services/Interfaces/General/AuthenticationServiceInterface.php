<?php

namespace App\Services\Interfaces\General;

interface AuthenticationServiceInterface
{
    public function login(array $data);
    public function logout();
}
