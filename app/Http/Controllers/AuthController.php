<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $email = $request->only('email');
            $password = $request->password;

            $user = User::where('email', $email)->first();
            if (!Hash::check($password, $user->password)) {
                return response()->json([
                    'message' => 'Email or password are incorrect',
                    'status' => 404
                ], 404);
            }

            if ($user) {
                $token = $user->createToken($user->id)->plainTextToken;
            }

            return response()->json([
                'message' => "login successfully",
                'token' => $token,
                'status' => 200
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Email or password are incorrect',
                'status' => 404
            ], 404);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out',
            'status' => 200
        ], 200);
    }

    public function register(Request $request)
    {
        $attributes = $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string',
            'age' => 'nullable|integer',
            'gender' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'password' => 'required|string|confirmed',
        ]);

        $attributes['password'] = bcrypt($attributes['password']);
        $user = User::create($attributes);

        $token = $user->createToken($user->id)->plainTextToken;

        $data['message'] = 'This is a test';
        Mail::to("majd.m4a4@gmail.com")->send(new SendMail($data));

        return response()->json([
            'message' => "Account created successfully",
            'token' => $token,
            'status' => 201
        ], 201);
    }


    public function verify(Request $request)
    {
        $user = auth('sanctum')->user();

        try {
            Auth::routes(['verify' => true]);

            if ($user->hasVerifiedEmail()) {
                return view('auth.verify', ['model' => $user]);
            }

            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
            }

            return view('auth.verify', ['model' => $user]);
        } catch (\Throwable $th) {
             throw $th;
        }
    }
}
