<?php

namespace App\Services;

use App\Exceptions\LoginInvalidException;
use App\Exceptions\UserHasBeenTakenException;
use App\User;
use Str;

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

    public function register(string $first_name, string $last_name, string $email, string $password) {
       
        //verificando ser usuário existe
        $user = User::where('email', $email)->exists();
        if (!empty($user)) {
            throw new UserHasBeenTakenException();
        }

        $userPassword = bcrypt($password ?? Str::random(10));

        $user = User::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $userPassword,
            'confirmation_token' => Str::random(60),
        ]);

        return $user;
    }
}
