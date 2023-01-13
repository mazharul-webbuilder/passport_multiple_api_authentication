<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::create($validate);

        $token = $user->createToken('api_token')->accessToken;

        return response()->json(['status' => 1, 'token' => $token, 'data' => $user], 201);
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where(['email' => $request->email, 'password' => $request->password])->first();

        $token = $user->createToken('api_token')->accessToken;

        return response()->json(['status' => 'login successfully', 'token' => $token, 'data' => $user], 201);

    }

    public function userInfo($id)
    {
        $user = User::find($id);

        return $user;
    }
}
