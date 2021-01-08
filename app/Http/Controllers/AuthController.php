<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\AuthLoginRequest;
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
}
