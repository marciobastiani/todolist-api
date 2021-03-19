<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class MeController extends Controller
{
    public function __construct() {

        $this->middleware('auth:api');
        
    }

    public function index() {
        return new UserResource(auth()->user());
    }
}
