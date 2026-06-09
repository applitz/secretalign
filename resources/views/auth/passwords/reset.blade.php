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
            <h5 class="text-white font-size-20">Reset Password</h5>
            <p class="text-white-50 mb-0">
                Create a new password for your account.
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

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden"
                       name="token"
                       value="{{ request()->route('token') }}">

                <div class="mb-3">
                    <label class="form-label">Email Address</label>

                    <input type="email"
                           name="email"
                           value="{{ request()->email }}"
                           class="form-control @error('email') is-invalid @enderror"
                           readonly>

                    @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password" class="form-control password-field"
                        name="password" placeholder="New Password">
                    <span class="input-group-text toggle-password" style="cursor:pointer">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>

                <div class="input-group mb-3">
                    <input type="password" class="form-control password-field"
                        name="password_confirmation" placeholder="Confirm Password">
                    <span class="input-group-text toggle-password" style="cursor:pointer">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>

                <div class="mt-3">
                    <button type="submit"
                            class="btn btn-primary w-100 waves-effect waves-light">
                        Reset Password
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-password').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const input = this.closest('.input-group').querySelector('input');
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    });
</script>
@endsection
