<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $attributes  = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => bcrypt($attributes['password']),
        ]);

        $token = $user->createToken('apiToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return Response($response);
    }

    public function login(Request $request)
    {
        $attributes  = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if (! Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
        }

        Auth::user()->tokens()->delete();
        $token = Auth::user()->createToken('apiToken')->plainTextToken;

        $response = [
            'user' => Auth::user(),
            'token' => $token
        ];

        return Response($response);
    }
}
