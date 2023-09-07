<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized', 'success' => false, 'status' => 401], 401);
        }

        return response()->json(['status' => 200, 'success' => true, 'message' => 'Login Successful', 'token' => $token]);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'email' => $request->input('email'),
            'password' => $request->input('password') //in user model type cast for password is already done so don't need to hash heres
        ]);
        $token = JWTAuth::fromuser($user);
        return response()->json(['success' => true,'status' => 200, 'message' => 'User registered successfully', 'token' => $token]);
    }

    public function logout(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::invalidate($token);
        } catch (JWTException $e) {
        }

        return response()->json(['status' => 200, 'message' => 'Successfully logged out']);
    }

    public function profileShow(){
        $userData['name'] = Auth::user()->name ?? '';
        $userData['email'] = Auth::user()->email;
        $userData['role'] = Auth::user()->role;
        return response()->json(['status' => 200, 'success' => true, 'data' => $userData]);
    }


}
