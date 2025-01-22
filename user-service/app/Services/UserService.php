<?php

namespace App\Services;
use App\Events\OrderPlaced;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Events\UserCreated;
use Illuminate\Support\Facades\Auth;


class UserService
{
    public function list()
    {
        // Place order logic here
        return  User::all();
    }

    public function create($userData){
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);
        event(new UserCreated($user->toArray()));
        return $user;
    }

    public function authToken($email,$password){
        if (Auth::attempt(['email'=>$email,'password'=> $password])) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return $token;
        }
        return false;
    }
  

   
}