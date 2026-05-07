@extends('layouts.app_base_horizontal')

@section('content')

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">User Profile</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Settings</li>
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
                    <form class="save-form" method="POST" action="{{ url('/profile-settings/' . $user->id) }}"
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
                            <input class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                type="text" value="{{ $user->last_name }}" placeholder="Last Name" name="last_name">
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="phone_number">Phone Number</label>
                            <input type="tel"
                                class="form-control @error('phone_number')
                            is-invalid
                        @enderror"
                                name="phone_number" id="phone_number" value="{{ $user->phone_number }}"
                                placeholder="Phone Number">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="billing_address">Billing Address</label>
                            <textarea
                                class="form-control @error('billing_address')
                                is-invalid
                            @enderror"
                                name="billing_address" id="billing_address" placeholder="Billing Address">{{ $user->billing_address }}</textarea>
                            @error('billing_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="shipping_address">Shipping Address</label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror" name="shipping_address" id="shipping_address" placeholder="Shipping Address">{{ $user->shipping_address }} </textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="postal_code">Postal Code</label>
                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" id="postal_code" placeholder="Postal Code" value="{{ old('postal_code', $user->postal_code) }}">
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="city">City</label>
                            <input type="text"
                                class="form-control @error('city') is-invalid @enderror"
                                name="city"
                                id="city"
                                placeholder="City"
                                value="{{ old('city', $user->city) }}">

                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="country">Country</label>
                            <input type="text"
                                class="form-control @error('country') is-invalid @enderror"
                                name="country"
                                id="country"
                                placeholder="Country"
                                value="{{ old('country', $user->country) }}">

                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email"
                                value="{{ $user->email }}" type="email" placeholder="Email" name="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="doctor_id">Dental Monitoring Doctor Id</label>
                            <input class="form-control @error('doctor_id') is-invalid @enderror" id="doctor_id"
                                value="{{ $user->doctor_id }}" type="text" placeholder="Please enter dental-monitoring doctor Id" name="doctor_id">
                            @error('doctor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="shining3d_org_name">Shining3d Organization Name
                                <a href="javascript:;" class="text-info" data-bs-toggle="modal" data-bs-target="#shining3d-organization-name-modal">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </label>
                            <input class="form-control @error('shining3d_org_name') is-invalid @enderror" id="shining3d_org_name"
                                value="{{ $user->shining3d_org_name }}" type="text" placeholder="Please enter shining3d organization name" name="shining3d_org_name">
                            @error('shining3d_org_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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
                            <span class="text-muted mb-2" style="display:inherit;">* must contain at least one digit</span>

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
                                <input type="password"
                                    class="form-control @error('confirm_password') is-invalid @enderror"
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

            <div class="card mb-3">
                <div class="card-body ">
                    <h4 class="card-title mb-3">Change Profile Photo</h4>
                    <form method="POST" action="{{url('/profile-settings/change-profile-photo/'.$user->id)}}" enctype="multipart/form-data">@csrf
                        <div class="mb-3">
                            <label class="form-label">Upload Profile Photo</label>
                            <span class="text-muted mb-2" style="display:inherit;">* max file size: 2mb</span>
                            <span class="text-muted mb-2" style="display:inherit;">* only jpg, jpeg, png, and webp are allowed</span>
                            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".jpeg,.jpg,.png,.webp">
                            @error('file')
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
    {{-- <script>
        // get the eye icon and password input field
        const eyeIcon = document.querySelector('.form-password-toggle .input-group-text');
        const passwordField = document.querySelector('.form-password-toggle input[type="password"]');

        // toggle the password field visibility and icon on click
        eyeIcon.addEventListener('click', () => {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordField.type = 'password';
                eyeIcon.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
    </script> --}}
@stop
