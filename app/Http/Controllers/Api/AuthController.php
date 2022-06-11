<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function signup(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users',
            'password' => 'required|string'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();

        return response()->json([
            'success' => 'success',
            'data' => $user
        ]);
    }

    public function login(Request $request)
    {
        //echo "Login Successfully";
        $request->validate([

            'email' => 'required|email|string',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(['massage' => 'Invalied Email or Password Failed'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('Access Token');
        $user->access_token = $token->accessToken;

        return response()->json(["user" => $user],200);
    }

    public function logout(Request $request)
    {
        if ($request->user()) { 
            $request->user()->tokens()->delete();
        }
       return response()->json(['message'=>'User logged out'],200);
    }
    public function index()
    {
        echo "Welcome to Coder Camp";
    }
}
