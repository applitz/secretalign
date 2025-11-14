<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Al Secret | Dashboard &amp;</title>




    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    {{--
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{asset('public/dashboard')}}/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{asset('public/dashboard')}}/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{asset('public/dashboard')}}/assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/dashboard')}}/assets/img/favicons/favicon.ico">
    <link rel="manifest" href="{{asset('public/dashboard')}}/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="{{asset('public/dashboard')}}/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff"> --}}
    <script src="{{ asset('public/dashboard') }}/assets/js/config.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="{{ asset('public/dashboard') }}/vendors/choices/choices.min.css" rel="stylesheet" />
    <link href="{{ asset('public/dashboard') }}/vendors/flatpickr/flatpickr.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('public/dashboard') }}/vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link href="{{ asset('public/dashboard') }}/assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('public/dashboard') }}/assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="{{ asset('public/dashboard') }}/assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('public/dashboard') }}/assets/css/user.min.css" rel="stylesheet" id="user-style-default">

    <style>
        .choices__inner {
            min-height: 36px !important
        }

        .choices .choices__list--single {
            margin-top: 1px !important
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #4d5969;
            background-color: #fff;
            border-color: #fff;
            box-shadow: 0 0 0 1px rgba(43, 45, 80, 0.1), 0 2px 5px 0 rgba(43, 45, 80, 0.08), 0 1px 1.5px 0 rgba(0, 0, 0, 0.07), 0 1px 2px 0 rgba(0, 0, 0, 0.08);
        }
    </style>
    @yield('css')
    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>

</head>


<body>
    <div id="loader" class="loader d-none" style="position: fixed;left: 47%;top:40%;z-index: 1000">
        <div class="spinner-border " style="--falcon-text-opacity: 1;color: #8A6A3F;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div id="loader-overlay" class="loader-overlay d-none"
        style="position: fixed;width: 100%;height: 100%;background: rgba(7, 6, 6, 0.3);top: 0;z-index: 500"></div>

    @include('cookie-consent::index')
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <script>
                var isFluid = true;//JSON.parse(localStorage.getItem('isFluid'));
                if (isFluid) {
                    var container = document.querySelector('[data-layout]');
                    container.classList.remove('container');
                    container.classList.add('container-fluid');
                }
            </script>
            <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand-lg">

                <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarStandard" aria-controls="navbarStandard"
                    aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                            class="toggle-line"></span></span></button>
                <a class="navbar-brand me-1 me-sm-3" href="{{ url('/') }}">
                    <div class="d-flex align-items-center">
                        <img class="me-2" src="{{ asset('public') }}/assets/high-res_4x.png" alt="" width="210" />
                    </div>
                </a>
                <div class="collapse navbar-collapse scrollbar" id="navbarStandard">
                    <ul class="navbar-nav" data-top-nav-dropdowns="data-top-nav-dropdowns">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/home') }}" role="button" aria-haspopup="true"
                                aria-expanded="false" id="dashboards">Dashboard</a>
                        </li>
                        @if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'rep')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/orders') }}" role="button" aria-haspopup="true"
                                aria-expanded="false" id="orders">Orders</a>
                        </li>
                        @endif
                        @if (Auth::user()->role == 'superadmin')

                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/reports/lab-requests') }}" role="button"
                                aria-haspopup="true" aria-expanded="false" id="orders">Lab Requests</a>
                        </li>
                        @endif
                        @if (Auth::user()->role != 'rep')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" id="users">Patient</a>
                            <div class="dropdown-menu dropdown-menu-card border-0 mt-0" aria-labelledby="dashboards">
                                <div class="bg-white dark__bg-1000 rounded-3 py-2">
                                    @if (Auth::user()->role == 'doctor')
                                    <a class="dropdown-item link-600 fw-medium"
                                        href="{{ url('/patient/create') }}">Create
                                        Patient</a>
                                    @endif
                                    @if (Auth::user()->role == 'doctor')
                                    <a class="dropdown-item link-600 fw-medium"
                                            href="{{ url('/patients') }}">Manage
                                            Patients</a>
                                    @else
                                        <a class="dropdown-item link-600 fw-medium"
                                            href="{{ url('/patients/view') }}">Manage
                                            Patients</a>
                                    @endif
                                </div>
                            </div>
                        </li>
                        @endif
                        @if(Auth::user()->role == 'staff' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/patients/orders/finished/view') }}" role="button"
                                aria-haspopup="true" aria-expanded="false" id="finished_orders">Finished Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/contracts/data-processing-documents/view') }}" role="button"
                                aria-haspopup="true" aria-expanded="false" id="doctors">Doctors</a>
                        </li>
                        @endif
                        @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'rep')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" id="users">User</a>
                            <div class="dropdown-menu dropdown-menu-card border-0 mt-0" aria-labelledby="dashboards">
                                <div class="bg-white dark__bg-1000 rounded-3 py-2">
                                    <a class="dropdown-item link-600 fw-medium" href="{{ url('/user/add') }}">Register
                                        User</a>
                                    <a class="dropdown-item link-600 fw-medium" href="{{ url('/users/view') }}">Manage
                                        Users</a>
                                </div>
                            </div>
                        </li>
                        @if (Auth::user()->role == 'superadmin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" id="settings">Settings</a>
                            <div class="dropdown-menu dropdown-menu-card border-0 mt-0" aria-labelledby="dashboards">
                                <div class="bg-white dark__bg-1000 rounded-3 py-2">
                                    <a class="dropdown-item link-600 fw-medium" href="{{ url('/tier-settings') }}">Tier
                                        Settings</a>
                                    <!--<a class="dropdown-item link-600 fw-medium"
                                        href="{{ url('/treatment-plan-phase-period-settings') }}">Phase
                                        Period Settings</a>-->
                                </div>
                            </div>
                        </li>
                        @endif
                        @endif
                    </ul>
                </div>
                <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                    <li class="nav-item">
                        <div class="theme-control-toggle fa-icon-wait px-2">
                            <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle"
                                type="checkbox" data-theme-control="theme" value="dark" />
                            <label class="mb-0 theme-control-toggle-label theme-control-toggle-light"
                                for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left"
                                title="Switch to light theme"><span class="fas fa-sun fs-0"></span></label>
                            <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark"
                                for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left"
                                title="Switch to dark theme"><span class="fas fa-moon fs-0"></span></label>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link notification-indicator notification-indicator-primary px-0 notification-indicator-fill fa-icon-wait"
                            id="navbarDropdownNotification" href="#" role="button" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><span class="fas fa-bell"
                                data-fa-transform="shrink-6" style="font-size: 33px;"></span>
                            <span class="notification-indicator-number" id="notifications-count">0</span></a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-card dropdown-menu-notification"
                            aria-labelledby="navbarDropdownNotification">
                            <div class="card card-notification shadow-none">
                                <div class="card-header">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <h6 class="card-header-title mb-0">Notifications</h6>
                                        </div>
                                        {{-- <div class="col-auto ps-0 ps-sm-3"><a class="card-link fw-normal"
                                                href="#">Mark
                                                all as read</a></div> --}}
                                    </div>
                                </div>
                                <div class="scrollbar-overlay" style="max-height:19rem">
                                    <div class="list-group list-group-flush fw-normal fs--1">
                                        <div class="list-group-item" id="notifications-dropdown">

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center border-top"><a class="card-link d-block"
                                        href="{{ url('/view-notifications') }}">View all</a></div>
                            </div>
                        </div>

                    </li>
                    {{-- <li class="nav-item dropdown"><a class="nav-link pe-0" id="navbarDropdownUser" href="#"
                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-xl">
                                <img class="rounded-circle" src="{{ asset('public/assets/avatar.svg') }}" alt="" />

                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                            <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                <a class="dropdown-item" href="{{ url('/profile-settings') }}">
                                    Profile &amp; account
                                </a>
                                <a class="dropdown-item" href="javascript:;"
                                    onclick="document.getElementById('logout-form').submit()">
                                    Logout
                                </a>
                                <form method="POST" id="logout-form" action="{{ route('logout') }}">@csrf</form>
                            </div>
                        </div>
                    </li> --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link pe-0 d-flex align-items-center position-relative" id="navbarDropdownUser"
                            href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <div class="avatar avatar-xl">
                                <img class="rounded-circle"
                                    src="{{ asset('public/dashboard/assets/img/team/avatar.png') }}"
                                    style="padding: 1px;" alt="">

                            </div>
                            <div class="ms-2">
                                <h6 class="mb-0 fw-semi-bold text-800" style="font-size:0.7333333333rem">
                                    {{Auth::user()->first_name . ' ' .
                                    Auth::user()->last_name}}</h6>
                                <p class="text-500 fs--2 mb-0">
                                    @if(Auth::user()->role == 'rep')
                                    Partner
                                    @else
                                    {{ucfirst(Auth::user()->role)}}
                                    @endif
                                </p>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                            <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                <a class="dropdown-item" href="{{ url('/profile-settings') }}">
                                    Profile &amp; account
                                </a>
                                <a class="dropdown-item" href="javascript:;"
                                    onclick="document.getElementById('logout-form').submit()">
                                    Logout
                                </a>
                                <form method="POST" id="logout-form" action="{{ route('logout') }}">@csrf</form>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="content">
                @yield('content')

            </div>
        </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->



    @include('layouts.footer')

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">

        <div class="toast fade" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-primary text-white"><strong class="me-auto" id="alert-message-title"></strong>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body" id="alert-message-body"></div>
        </div>


        @if (Session::get('error'))
        <div class="toast fade liveToast" id="liveToast1" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white"><strong class="me-auto">Error</strong><small></small>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body">{{ Session::get('error') }}</div>
        </div>
        @endif
        @if (Session::get('success'))
        <div class="toast fade liveToast" id="liveToast2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white"><strong class="me-auto">Success</strong><small></small>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body">{{ Session::get('success') }}</div>
        </div>
        @endif
        <div class="toast fade" id="liveToast3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white"><strong class="me-auto">Success</strong><small></small>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body" id="success-message"></div>
        </div>
        <div class="toast fade" id="liveToast4" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white"><strong class="me-auto">Error</strong><small></small>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body" id="error-message"></div>
        </div>
    </div>

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('public/dashboard') }}/vendors/popper/popper.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/anchorjs/anchor.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/is/is.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/echarts/echarts.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/fontawesome/all.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/list.js/list.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/assets/js/theme.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/choices/choices.min.js"></script>
    <script src="{{ asset('public/dashboard/') }}/assets/js/flatpickr.js"></script>

    <script>
        function showLoader() {
            $('#loader').removeClass('d-none');
            $('#loader-overlay').removeClass('d-none');
        }

        function hideLoader() {
            $('#loader').addClass('d-none');
            $('#loader-overlay').addClass('d-none');
        }
        var toastElList = [].slice.call(document.querySelectorAll('.liveToast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl)
        })
        for (var t = 0; t < toastList.length; t++) {
            toastList[t].show();
        }

        function toastSuccess(message) {
            document.getElementById("success-message").innerHTML = message;
            var toastLiveExample = document.getElementById('liveToast3')
            var toast = new bootstrap.Toast(toastLiveExample)
            toast.show()
        }

        function toastError(message) {
            document.getElementById("error-message").innerHTML = message;
            var toastLiveExample = document.getElementById('liveToast4')
            var toast = new bootstrap.Toast(toastLiveExample)
            toast.show()
        }
    </script>
    <script>
        // get all the form-password-toggle elements on the page
        const passwordToggles = document.querySelectorAll('.form-password-toggle');

        // loop through each form-password-toggle element and attach the click event listener
        passwordToggles.forEach((toggle) => {
            // get the eye icon and password input field for this toggle
            const eyeIcon = toggle.querySelector('.input-group-text');
            const passwordField = toggle.querySelector('input[type="password"]');

            // attach the click event listener to the eye icon
            eyeIcon.addEventListener('click', () => {
                // toggle the password field visibility and icon
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    eyeIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    passwordField.type = 'password';
                    eyeIcon.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });
    </script>

    @yield('javascript')
    <script>
        function checkNotifications() {
                var data = {
                    "_token": "{{ csrf_token() }}",
                    "type": "fetch-api",
                }
                fetch('{{ url('/notifications') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => {
                        return response.text();
                    })
                    .then(data => {
                        container.innerHTML = data;
                        var count = document.getElementById("unread-notifications");
                        var bell = document.getElementById("notifications-count");
                        if (parseInt(count.value) > 9) {
                            bell.innerHTML = "9+";
                        } else {
                            bell.innerHTML = count.value;
                        }

                    })
                    .catch(error => console.error(error));

            }
            checkNotifications();
            var container = document.getElementById("notifications-dropdown");

            setInterval(() => {
                checkNotifications();
            }, 30000);
    </script>
</body>

</html>
