<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthVerifyEmailRequest;
use App\Http\Requests\AuthForgotPasswordRequest;
use App\Http\Requests\AuthResetPasswordRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authservice;
    
    public function __construct(AuthService $authservice) {
        $this->authservice = $authservice;
    }
    
    public function login(AuthLoginRequest $request) {
        $input = $request->validated();

        $token = $this->authservice->login($input['email'], $input['password']);

        $resource = new UserResource(auth()->user());
        return ($resource)->additional($token);
    }

    public function register(AuthRegisterRequest $request) {
        $input = $request->validated();

        $user = $this->authservice->register($input['first_name'], $input['last_name'] ?? '', $input['email'], $input['password']);
        
        return new UserResource($user);
    }

    public function verifyEmail(AuthVerifyEmailRequest $request) {
        
        $input = $request->validated();

        $user = $this->authservice->verifyEmail($input['token']);
        
        return new UserResource($user);
    }

    public function forgotPassword(AuthForgotPasswordRequest $request) {
        
        $input = $request->validated();

        return $this->authservice->forgotPassword($input['email']);
    }

    public function resetPassword(AuthResetPasswordRequest $request) {

        $input = $request->validated();

        return $this->authservice->resetPassword($input['email'], $input['password'], $input['token']);
    }
}
