<?php

namespace App\Services;

use App\Exceptions\LoginInvalidException;
use App\Exceptions\UserHasBeenTakenException;
use App\Exceptions\VerifyEmailTokenInvalidException;
use App\User;
use App\PasswordReset;
use App\Events\UserRegistered;
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

        event(new UserRegistered($user));

        return $user;
    }

    public function verifyEmail(string $token) {

        $user = User::where('confirmation_token', $token)->first();

        if (empty($user)) {
            throw new VerifyEmailTokenInvalidException();
            
        }

        $user->confirmation_token = null;
        $user->email_verified_at = now();
        $user->save();

        return $user;
    }

    public function forgotPassword(string $email) {
        $user = User::where('email', $email)->firstOrFail();

        PasswordReset::create([
            'email' => $user->email,
            'token' => Str::random(60)
        ]);

        return '';
    }
}
