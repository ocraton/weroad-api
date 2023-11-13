<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            return response()->json([
                'access_token' => $user->createToken($user->email)->plainTextToken,
            ]);

        } else {

            return response()->json(['error' => 'Credentials are not valid'], 422);

        }
    }

    public function logout()
    {
        if (Auth::check()) {

            Auth::user()->tokens->each(function ($token) {
                $token->delete();
            });

            return response()->json(['success' => 'Token Deleted']);

        } else {

            return response()->json(['error' => 'No Authenticated User']);
        }
    }
}
