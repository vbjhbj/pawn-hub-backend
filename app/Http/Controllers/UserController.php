<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facader\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create(Request $request){
        $user = new User;
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->isCustomer = $request->input('isCustomer');
        
		$user->save();
    }
    public function login(Request $request){

        $name = $request->input('username');
        $password = $request->input('password');

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $name)->first() ?? User::where('email', $name)->first();

        //Hash::check($password, $password ? $user->password : '')
        if (!$user){
            return response()->json([
                'error' => [
                    'code' => "USER_NOT_FOUND",
                    'message' => 'Invalid username or email address.'
                ]

            ], 401);
        }
        else if (!Hash::check($password, $password ? $user->password : '')) {
            return response()->json([
                'error' => [
                    'code' => "INVALID_PASSWORD",
                    'message' => 'Invalid password.'
                ]

            ], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'auth_token' => $token,
        ])->cookie('auth_token', $token, 60 * 24 * 365 * 2, '/', null, false, true);
    }
}
