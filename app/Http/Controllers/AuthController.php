<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authservice;
    
    public function __construct(AuthService $authservice) {
        $this->authservice = $authservice;
    }
    
    public function login() {
        $this->authservice->login();
    }
}
