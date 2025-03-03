<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        $user = User::where('username', $name)->first();
        //Hash::check($password, $password ? $user->password : '')
        if (!$user || !Hash::check($password, $password ? $user->password : '')){
            return response()->json([
                'message' => 'invalid name or password',
            ], 401);
        }
        $user->tokens()->delete();

        $user->token = $user->createToken('access')->plainTextToken;

        return response()->json([
            'user' => $user,
        ]);
    }
}
