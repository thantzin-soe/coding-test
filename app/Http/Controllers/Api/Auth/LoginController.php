<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $access_token = $request->authenticate();

        return response()->json([
            'success' => true,
            'access_token' => $access_token
        ]);
    }

    public function logOut(Request $request)
    {
        $user = auth('sanctum')->user();

        $user->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout success!'
        ]);
    }
}
