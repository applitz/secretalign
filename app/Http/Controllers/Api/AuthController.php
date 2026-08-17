<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->has('email') && $errors->has('password')) {
                $message = 'Email and password are required.';
            } elseif ($errors->has('email')) {
                $message = 'Email is required.';
            } elseif ($errors->has('password')) {
                $message = 'Password is required.';
            } else {
                $message = 'Please correct the errors and try again.';
            }

            return response()->json([
                'status' => false,
                'message' => $message,
                'errors' => $errors,
            ], 422);
        }

        $user = User::where('email', $request->email)
            ->where('role', 'doctor')
            ->select(
                'id',
                'first_name',
                'last_name',
                'phone_number',
                'country',
                'email',
                'password'
            )
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }

        // Optional: remove old tokens if you want only one active token
        // $user->tokens()->delete();

        $token = $user->createToken(
            'api-token',
            ['*']
        )->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful.',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
            ],
        ], 200);
    }
}
