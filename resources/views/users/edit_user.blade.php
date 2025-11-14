@extends('layouts.app_base_horizontal')

@section('content')
<div class="page-content">


    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Users</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/users/view')}}">Users</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body ">
                    <h4 class="card-title mb-3">Edit</h4>
                    <form class="save-form" method="POST" action="{{ url('/user/update/' . $user->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="first_name">First Name</label>
                            <input class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                                type="text" value="{{ $user->first_name }}" placeholder="First Name" name="first_name">
                            @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="last_name">Last Name</label>
                            <input class="form-control @error('last_name') is-invalid @enderror" id="last_name" type="text"
                                value="{{ $user->last_name }}" placeholder="Last Name" name="last_name">
                            @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="phone_number">Phone Number</label>
                            <input type="tel" class="form-control @error('phone_number')
                                is-invalid
                            @enderror" name="phone_number" id="phone_number" value="{{ $user->phone_number }}"
                                placeholder="Phone Number">
                            @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="billing_address">Billing Address</label>
                            <textarea class="form-control @error('billing_address')
                                    is-invalid
                                @enderror" name="billing_address" id="billing_address"
                                placeholder="Billing Address">{{ $user->billing_address }}</textarea>
                            @error('billing_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="mb-3">
                            <label class="form-label" for="shipping_address">Shipping Address</label>
                            <textarea class="form-control @error('shipping_address')
                                    is-invalid
                                @enderror" name="shipping_address" id="shipping_address"
                                placeholder="Shipping Address">{{ $user->shipping_address }}</textarea>
                            @error('shipping_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email"
                                value="{{ $user->email }}" type="email" placeholder="Email" name="email">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if ($user->role != 'superadmin')
                        <div class="mb-3">
                            <label for="role">Role/Privileges</label>
                            <select class="form-select  @error('role') is-invalid @enderror" id="role" name="role">
                                <option value="">Select role...</option>
                                <option value="advisor" @if ($user->role == 'advisor') selected @endif>Asvisor</option>
                                <option value="doctor" @if ($user->role == 'doctor') selected @endif>Doctor</option>
                                <option value="staff" @if ($user->role == 'staff') selected @endif>Staff</option>
                                <option value="rep" @if ($user->role == 'rep') selected @endif>Secret Partner
                                </option>
                                <option value="lab" @if ($user->role == 'lab') selected @endif>Lab Technician
                                </option>
                            </select>
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @else
                        <input type="hidden" name="role" value="superadmin">
                        @endif

                        @if ($user->role == 'doctor')
                        <div class="mb-3">
                            <label for="tier">Tier</label>
                            <select class="form-select @error('tier')
                            is-invalid
                        @enderror" name="tier" id="tier">
                                @foreach ($tiers as $tier)
                                <option value="{{ $tier->id }}" @if ($user->tier == $tier->id) selected @endif>{{
                                    $tier->tier_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        @endif
                         @if ($user->role == 'advisor')
                          <div class="mb-3" id="advisorPrice">
                        <label for="tier">Advsior Quote</label>
                          <input type="advisor_price" class="form-control @error('advisor_price') is-invalid @enderror"
                            id="advisor_price" placeholder="Enter Advisor Quote" name="advisor_price"
                            aria-describedby="advisor_price" />
                    </div>
                    @endif



                        @if(Auth::user()->role == 'superadmin')
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="allow_login" value="1" id="flexSwitchCheckChecked"
                                    type="checkbox" @if($user->login == 1) checked="" @endif />
                                <label class="form-check-label" for="flexSwitchCheckChecked">
                                    @if($user->login == 0)
                                    Activate User
                                    @else
                                    Deactivate user
                                    @endif
                                </label>
                            </div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <input type="submit" name="submit" class="btn btn-primary waves-effect waves-light" value="Save Changes">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">

                <div class="card-body ">
                    <h4 class="card-title mb-3">Change Password</h4>
                    <form class="save-form" method="POST" action="{{ url('/user/change-password/' . $user->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <span class="text-muted" style="display:inherit;">* must be at least 6 characters in
                                length</span>
                            <span class="text-muted" style="display:inherit;">* must contain at least one lowercase
                                letter</span>
                            <span class="text-muted mb-2" style="display:inherit;">* must contain at least one
                                digit</span>
                            <div class="input-group form-password-toggle mb-2">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" placeholder="Password" name="password" aria-describedby="password" />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer h-100"><i class="fas fa-eye "></i></span>
                                </div>
                            </div>
                            @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="confirm_password">Confirm Password</label>
                            <span class="text-muted mb-2" style="display:inherit;">* password and confirm password must
                                match</span>
                            <div class="input-group form-password-toggle mb-2">
                                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror"
                                    id="confirm_password" placeholder="Confirm Password" name="confirm_password"
                                    aria-describedby="confirm_password" />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer h-100"><i class="fas fa-eye "></i></span>
                                </div>
                            </div>
                            @error('confirm_password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="submit" class="btn btn-primary waves-effect waves-light" value="Save Changes">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop


@section('javascript')

@stop
