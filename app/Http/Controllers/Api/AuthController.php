<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bycrypt($request->password),
        ]);
    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);

    }
}
