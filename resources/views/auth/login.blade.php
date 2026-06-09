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
    .btn{
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
            <h5 class="text-white font-size-20">Welcome Back!</h5>
            <p class="text-white-50 mb-0">Sign in to continue.</p>
             <a href="{{url('')}}" class="logo logo-admin overflow-hidden mt-4" style="">
                <img src="{{asset('public/assets/circle-logo.jpg')}}" style="      width: 200px;
    height: 200px;">
            </a>
        </div>
    </div>
    <div class="card-body pt-5">
        <div class="p-2 pt-5 mt-5">
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">

                <div class="mb-3">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email">
                    @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="userpassword">Password</label>
                    {{-- <input type="password" class="form-control @error('password') is-invalid @enderror" id="userpassword" name="password"
                    placeholder="Enter password"> --}}


                    <div class="input-group ">
                        <input type="password" class="form-control" id="validationTooltipUsername" placeholder="Enter password" aria-describedby="validationTooltipUsernamePrepend" name="password">
                        <div class="input-group-prepend " >
                            <span class="input-group-text h-100 password-toggle" style="cursor: pointer" id="validationTooltipUsernamePrepend">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>


                    @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"name="remember" id="remember" {{ old('remember')
                        ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>

                    @if (Route::has('forgot-password'))
                        <a href="{{ route('forgot-password') }}" class="text-primary">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log
                        In</button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection
