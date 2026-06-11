@extends('layouts.app_base_horizontal')

@section('content')

    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex flex-column mt-3">
                    <h4 class="page-title mb-0 font-size-18">Manage Users</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/users/view') }}">Users</a></li>
                            <li class="breadcrumb-item active">Register</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>


        <div class="card mb-3">
            <div class="card-body ">
                <h4 class="card-title mb-3">Register User</h4>


                <form class="save-form " method="POST" action="{{ url('/user/save') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="first_name">First Name</label>
                        <input class="form-control @error('first_name') is-invalid @enderror" id="first_name" type="text"
                            value="{{ old('first_name') }}" placeholder="First Name" name="first_name">
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="last_name">Last Name</label>
                        <input class="form-control @error('last_name') is-invalid @enderror" id="last_name" type="text"
                            value="{{ old('last_name') }}" placeholder="Last Name" name="last_name">
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
                            name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                            placeholder="Phone Number">
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="billing_address">Billing Address</label>
                        <textarea class="form-control @error('billing_address')
                    is-invalid
                @enderror"
                            name="billing_address" id="billing_address" placeholder="Billing Address">{{ old('billing_address') }}</textarea>
                        @error('billing_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="mb-3">
                <label class="form-label" for="shipping_address">Shipping Address</label>
                <textarea class="form-control @error('shipping_address')
                    is-invalid
                @enderror" name="shipping_address" id="shipping_address"
                    placeholder="Shipping Address">{{ old('shipping_address') }}</textarea>
                @error('shipping_address')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> --}}
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email"
                            value="{{ old('email') }}" type="email" placeholder="Email" name="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <span class="text-muted" style="display:inherit;">* must be at least 6 characters in length</span>
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
                            <input type="password" class="form-control @error('confirm_password') is-invalid @enderror"
                                id="confirm_password" placeholder="Confirm Password" name="confirm_password"
                                aria-describedby="confirm_password" />
                            <div class="input-group-append">
                                <span class="input-group-text cursor-pointer h-100"><i class="fas fa-eye "></i></span>
                            </div>
                        </div>
                        @error('confirm_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @if (Auth::user()->role == 'superadmin')
                        <div class="mb-3">
                            <label for="role">Role/Privileges</label>
                            <select class="form-select select2 @error('role') is-invalid @enderror" id="role" name="role">
                                <option value="">Select role...</option>
                                <option value="superadmin" @if (old('role') == 'superadmin') selected @endif>Superadmin
                                </option>
                                <option value="advisor" @if (old('role') == 'advisor') selected @endif>Advisor</option>
                                <option value="doctor" @if (old('role') == 'doctor') selected @endif>Doctor</option>
                                <option value="staff" @if (old('role') == 'staff') selected @endif>Staff</option>
                                <option value="rep" @if (old('role') == 'rep') selected @endif>Secret Partner
                                </option>
                                <option value="lab" @if (old('role') == 'lab') selected @endif>Lab Technician
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @else
                        <input type="hidden" name="role" value="doctor">
                    @endif

                    <div class="mb-3" id="doctorTier">
                        <label for="tier">Tier</label>
                        <select class="form-select @error('tier') is-invalid @enderror" name="tier" id="tier">
                            @foreach ($tiers as $tier)
                                <option value="{{ $tier->id }}">
                                    {{ $tier->tier_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="staffDiv">
                        <label for="staff">Staff</label>
                        <select class="form-select @error('staff') is-invalid @enderror" name="staff" id="staff">
                            <option value="">Select staff...</option>
                            @foreach ($staff as $staff)
                                <option value="{{ $staff->id }}">
                                    {{ $staff->first_name }} {{ $staff->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('staff')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="advisorPrice">
                        <label for="tier">Advsior Quote</label>
                        <input type="advisor_price" class="form-control @error('advisor_price') is-invalid @enderror"
                            id="advisor_price" placeholder="Enter Advisor Quote" name="advisor_price"
                            aria-describedby="advisor_price" />
                    </div>



                    <div class="mb-3">
                        <input type="submit" name="submit" class="btn btn-primary waves-effect waves-light"
                            value="Save Changes">
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop


@section('javascript')
    <script src="{{  asset('public/assets/customjs/superadmin/add-user.js') }}?v={{ time() }}"></script>
    <script>
        $(document).ready(function() {

            AddUser.init();
            $('.mySelect2').select2({
                closeOnSelect: false
            });
            $("#doctorTier").hide();
            $("#staffDiv").hide();
            $("#role").on("change", function() {
                var selectedRole = $(this).val();
                if (selectedRole === "doctor") {
                    $("#doctorTier").show();
                    $("#staffDiv").show();
                } else {
                    $("#doctorTier").hide();
                    $("#staffDiv").hide();
                }

                if (selectedRole === "advisor") {
                    $("#advisorPrice").show();
                } else {
                    $("#advisorPrice").hide();
                }

            });
            $("#role").trigger("change");
        });
    </script>
@stop
