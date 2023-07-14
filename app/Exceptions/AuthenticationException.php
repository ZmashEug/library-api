<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;

class CustomAuthenticationException extends AuthenticationException 
{
    public function __construct()
    {
        parent::__construct('Invalid credentials');
    }
}