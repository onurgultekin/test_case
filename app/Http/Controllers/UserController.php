<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request) {
        return $request->user();
    }
    
    public function login(Request $request) {
        $user = User::where('email', $request->email)->first();
        if (!$user || ($request->password !== $user->password)) {
            return $response = [
                'message' => 'We could not find the user with '.$request->email
            ];
        }
        $token = $user->createToken('meditopia-token')->plainTextToken;

        $response = [
            'user'=> $user,
            'token'=> $token
        ];
        return response($response, 201);
    }
}
