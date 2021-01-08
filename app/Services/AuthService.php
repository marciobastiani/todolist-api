<?php

namespace App\Services;

use App\Exceptions\LoginInvalidException;

class AuthService
{
    public function login(string $email, string $password) {
        $login = [
            'email'     => $email,
            'password'  => $password
        ];

        if (!$token = auth()->attempt($login)) {
            //erro
            throw new LoginInvalidException('Login ou senha inválidos');
        }

        return [
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ];
    }
}
