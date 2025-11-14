@extends('layouts.dashboard_layout')

@section('content')
<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url({{asset('public')}}/assets/img/icons/spot-illustrations/corner-4.png);">
    </div>
    <!--/.bg-holder-->

    <div class="card-body position-relative">
      <div class="row">
        <div class="col-lg-8">
          <h3>Profile Settings</h3>
        </div>
      </div>
    </div>
  </div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">
              <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                  <h5 class="mb-0">Edit</h5>
                </div>
              </div>
            </div>
            <div class="card-body bg-light">
                <form class="save-form" method="POST" action="{{url('/user/update/'.$user->id)}}">
                    @csrf
                <div class="mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" value="{{$user->name}}" placeholder="Name" name="name">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="email">Eamil</label>
                    <input class="form-control @error('email') is-invalid @enderror" id="email" value="{{$user->email}}" type="email" placeholder="Email" name="email">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </form>
            </div>
          </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">
              <div class="row flex-between-end">
                <div class="col-auto align-self-center">
                  <h5 class="mb-0">Change Password</h5>
                </div>
              </div>
            </div>
            <div class="card-body bg-light">
                <form class="save-form" method="POST" action="{{url('/user/change-password/'.$user->id)}}">
                    @csrf
                  <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" placeholder="Password" name="password">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                  <div class="mb-3">
                    <label class="form-label" for="confirm_password">Confirm Password</label>
                    <input class="form-control  @error('confirm_password') is-invalid @enderror" id="confirm_password" type="password" placeholder="Confirm Password" name="confirm_password">
                    @error('confirm_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                </form>
            </div>
          </div>
    </div>
</div>
@stop


@section('javascript')

@stop
