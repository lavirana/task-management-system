<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TaskResource;

class AuthController extends Controller
{

    use ApiResponse;


    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    $token = $user->createToken('api-token')->plainTextToken;
    return $this->success(['user' => $user, 'token' => $token], 'User registered successfully!', 201);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json(['message' => 'Invalid credentials'],401);
        }
        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

       //return response()->json(['token' => $token, 'user' => $user]);
        return $this->success([
            'user' => $user,
            'token' => $token
        ], 'Welcome back!');
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged Out']);
    }

}
