<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    //find the user in the database using the entered email
    $user = \App\Models\User::where('email', $request->email)->first();

    //throw error if no user found
    if(!$user){
        throw ValidationException::withMessages([
            'email' => 'Invalid Credentials'
        ]);
    }
    //check if the password match the existing one on the database
    if(!Hash::check($request->password, $user->password)){
       throw ValidationException::withMessages([
        'email' => 'Invalid Credentials'
       ]);
    }
    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'message' => 'Login successfully'
    ],200);
  }

  public function logout(Request $request)
  {
    $request->user()->tokens()->delete();

    return response()->json([
        'message' => 'Logged out successfully'
    ]);
  }
}
