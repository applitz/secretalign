<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function passwordEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'We could not find a user with that email address.'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'status',
                'Password reset instructions have been sent to your email address. Please check your inbox and spam folder.'
            );
        }

        if ($status === Password::RESET_THROTTLED) {
            return back()->withErrors([
                'email' => 'A password reset email was recently sent. Please wait a few minutes before requesting another reset link.'
            ]);
        }

        return back()->withErrors([
            'email' => __($status)
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        switch ($status) {
            case Password::PASSWORD_RESET:
                return redirect()
                    ->route('login')
                    ->with(
                        'status',
                        'Your password has been reset successfully. You may now sign in using your new password.'
                    );

            case Password::INVALID_TOKEN:
                return back()->withErrors([
                    'email' => 'This password reset link is invalid or has expired. Please request a new password reset link.'
                ]);

            case Password::INVALID_USER:
                return back()->withErrors([
                    'email' => 'We could not find an account associated with that email address.'
                ]);

            default:
                return back()->withErrors([
                    'email' => 'Unable to reset your password at this time. Please try again later.'
                ]);
        }
    }
}
