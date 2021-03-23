<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TodoResource;
use App\Http\Requests\TodoStoreRequest;
use App\Http\Requests\TodoUpdateRequest;
use App\Todo;

class TodoController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index() {
        return TodoResource::collection(auth()->user()->todos);
    }

    public function store(TodoStoreRequest $request) {
        $input = $request->validated();

        $todo = auth()->user()->todos()->create($input);

        return new TodoResource($todo);
    }

    public function update(Todo $todo, TodoUpdateRequest $request) {
        $input = $request->validated();

        $todo->fill($input);
        $todo->save();

        return new TodoResource($todo->fresh());
    }
}
