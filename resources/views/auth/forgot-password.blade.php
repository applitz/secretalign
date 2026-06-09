@extends('layouts.auth_base')

@section('content')
<style>
    .account-pages .logo-admin {
        width: 200px;
        height: 200px;
    }

    .form-control {
        font-size: 16px;
    }

    .btn {
        font-size: 20px;
    }

    .form-label {
        font-size: 17px;
    }
</style>

<div class="card overflow-hidden">
    <div class="bg-login text-center">
        <div class="bg-login-overlay"></div>
        <div class="position-relative">
            <h5 class="text-white font-size-20">Forgot Password?</h5>
            <p class="text-white-50 mb-0">
                Enter your email address and we'll send you a password reset link.
            </p>

            <a href="{{ url('/') }}" class="logo logo-admin overflow-hidden mt-4">
                <img src="{{ asset('public/assets/circle-logo.jpg') }}"
                     alt="Logo"
                     width="200"
                     height="200">
            </a>
        </div>
    </div>

    <div class="card-body pt-5">
        <div class="p-2 pt-5 mt-5">

            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm">
                    <h6 class="mb-2">
                        <i class="mdi mdi-email-check-outline"></i>
                        Email Sent Successfully
                    </h6>

                    <p class="mb-1">
                        Password reset instructions have been sent to your email address.
                    </p>

                    <small class="text-muted">
                        Didn't receive the email? Please check your Spam/Junk folder or wait a few minutes before requesting another reset link.
                    </small>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Enter your email address"
                        required
                        autofocus
                    >

                    @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mt-3">
                    <button type="submit"
                            class="btn btn-primary w-100 waves-effect waves-light">
                        Send Password Reset Link
                    </button>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">
                        Back to Login
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
