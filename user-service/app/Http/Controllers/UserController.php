<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function register(Request $request)
    {
        $validatedData = '';
        try{
            $validatedData =  $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        }catch(\Exception $e){
            return response()->json(['error' => 'Validation failed', 'messages' => $e->getMessage()], 422);
        }
        $user = $this->userService->create($validatedData);
      


        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
       $token = $this->userService->authToken($request->email,$request->password);
        if($token){
            return response()->json(['token' => $token]);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function index()
    {
        return $this->userService->list();
    }
}
