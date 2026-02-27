<!doctype html>
<html lang="en" >

    <head>
        <meta charset="utf-8" />
        <title>Dashboard | Secret Clear Aligner</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('public') }}/assets/favicon.png">

        <!-- jquery.vectormap css -->
        <link href="{{ asset('public/qovex') }}/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
            type="text/css" />
            <link href="{{ asset('public/dashboard') }}/vendors/flatpickr/flatpickr.min.css" rel="stylesheet" />
        <!-- Bootstrap Css -->
        <link href="{{ asset('public/qovex') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('public/qovex') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('public/qovex') }}/assets/css/app.min.css"  id="app-style"  rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <style>


            body[data-layout=detached] .container-fluid {
                max-width: 100%;
            }

            .ck-editor__editable_inline {
                min-height: 150px !important;
            }

            .accordion-button.bg-primary::after {
                filter: brightness(0) invert(1);
            }
            /* Apply border to entire DataTable */
            /* table.dataTable {
                border: 1px solid #d9d4d4 !important;
            } */

            /* Apply border to all table cells */
            /* table.dataTable th,
            table.dataTable td {
                border: 1px solid #d9d4d4 !important;
            } */

            /* Optional: Add border to header row only */
            /* table.dataTable thead th {
                border-bottom: 1px solid #d9d4d4 !important;
            } */

            /* Optional: Add border to footer if used */
            /* table.dataTable tfoot th {
                border-top: 1px solid #d9d4d4 !important;
            } */
            /* Smaller font and padding for compact view */
            select[name="tasks-list_length"] {
                border: 1px solid #d9d0d0;
            }
            #users-list {
                width: 100% !important;
            }
            /* Hide horizontal scrollbar */
            .dataTables_wrapper {
                overflow-x: hidden;
            }

            div.dataTables_wrapper div.dataTables_scrollBody {
                overflow-x: hidden !important;
            }
            body[data-layout=detached] #layout-wrapper::before {
                height: 165px;
                top: 70px;
                background: linear-gradient(to right,#1C8484,#1C8484);
                z-index: -1;
            }

            .badge-soft-marron {
                color: #2b647c; /* Dark maroon text */
                background-color: #d4e6ee; /* Soft maroon background */
                border: 1px solid #d4e6ee; /* Subtle border */
            }

            .box-body{
                border: 1px solid #bbbbbb;
                padding: 10px 15px;
                margin-bottom: 15px;
                border-radius: 10px;
            }
            .badge-soft-marron {
                color: #2b647c; /* Dark maroon text */
                background-color: #d4e6ee; /* Soft maroon background */
                border: 1px solid #d4e6ee; /* Subtle border */
            }
            body[data-layout=detached] #layout-wrapper::after {
                height: 165px;
                @if(@$_GET['i'] != 'true')
                top: 70px;
                @else
                top: 0;
                @endif
                background: url('{{asset('public/assets/header-bg.svg')}}') no-repeat center;
                background-size: cover;
                opacity: 1;
                z-index: -1;
            }
            body[data-topbar=colored] #page-topbar, body[data-topbar=dark] #page-topbar {
                background-color: #4D4D4D;
            }
            body[data-topbar=colored] #page-topbar {
                background: linear-gradient(to right,#4D4D4D,#4D4D4D)
            }
            .header-profile-user {
                height: 56px;
                width: 56px;
            }
            /* .noti-icon i {
                font-size: 32px;
            } */
            a {
                color: #1C8484;
            }
            a:hover {
                color: #4D4D4D;
            }
            body[data-layout=detached] .vertical-menu .user-img img {
                border-color: #1C8484;
            }
            .border-primary {
                border-color: #1C8484 !important;
            }
            .mm-active {
                color: #1C8484 !important;
            }
            .mm-active>i {
                color: #1C8484 !important;
            }
            .mm-active>a {
                color: #1C8484 !important;
            }
            .mm-active>a i {
                color: #1C8484 !important;
            }
            .mm-active .active {
                color: #1C8484 !important;
            }
            .mm-active .active i {
                color: #1C8484 !important;
            }

            .vertical-collpsed .vertical-menu #sidebar-menu>ul>li:hover>a i {
                color: #1C8484;
            }
            .vertical-collpsed .vertical-menu #sidebar-menu>ul>li:hover>a {
                color: #1C8484;
            }

            .page-title-box .page-title {
        line-height: 20px;
    }
                @media (min-width: 992px)
    {
        body[data-layout=detached] .page-title-box .page-title {
        line-height: 20px;
    }
    }
    .bg-soft-primary {
        background-color: rgba(28, 132, 132,.25)!important
    }
    .badge-soft-primary {
        color: #1C8484 !important;
        background-color: rgba(28, 132, 132,.25)!important
    }
    .active>.page-link, .page-link.active {
        background-color: #1C8484 !important;
        border-color: #1C8484 !important;
    }
    .text-primary {
        color: #1C8484 !important;
    }
    .btn-primary {
        --bs-btn-color: #fff;
        --bs-btn-bg: #1C8484;
        --bs-btn-border-color: #1C8484;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #499596;
        --bs-btn-hover-border-color: #499596;
        --bs-btn-focus-shadow-rgb: 88,117,235;
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: #499596;
        --bs-btn-active-border-color: #499596;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(77, 77, 77, 0.125);
        --bs-btn-disabled-color: #fff;
        --bs-btn-disabled-bg: #1C8484;
        --bs-btn-disabled-border-color: #1C8484;
    }
    .btn-outline-primary {
        --bs-btn-color: #1C8484;
        --bs-btn-border-color: #1C8484;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #1C8484;
        --bs-btn-hover-border-color: #1C8484;
        --bs-btn-focus-shadow-rgb: 59,93,231;
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: #1C8484;
        --bs-btn-active-border-color: #1C8484;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(77, 77, 77, 0.125);
        --bs-btn-disabled-color: #1C8484;
        --bs-btn-disabled-bg: transparent;
        --bs-btn-disabled-border-color: #1C8484;
        --bs-gradient: none;
    }
    .btn-link {
        --bs-btn-font-weight: 400;
        --bs-btn-color: #1C8484;
        --bs-btn-bg: transparent;
        --bs-btn-border-color: transparent;
        --bs-btn-hover-color: #499596;
        --bs-btn-hover-border-color: transparent;
        --bs-btn-active-color: #499596;
        --bs-btn-active-border-color: transparent;
        --bs-btn-disabled-color: #4d4d4d;
        --bs-btn-disabled-border-color: transparent;
        --bs-btn-box-shadow: 0 0 0 #000;
        --bs-btn-focus-shadow-rgb: 88,117,235;
        text-decoration: none;
    }
    .form-control:focus {
        border-color: #499596;
        box-shadow: 0 0 0 0.25rem rgba(28, 132, 132,.25)
    }
    .form-select:focus {
        border-color: #499596;
        box-shadow: 0 0 0 0.25rem rgba(28, 132, 132,.25)
    }

    .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange, .flatpickr-day.selected.inRange, .flatpickr-day.startRange.inRange, .flatpickr-day.endRange.inRange, .flatpickr-day.selected:focus, .flatpickr-day.startRange:focus, .flatpickr-day.endRange:focus, .flatpickr-day.selected:hover, .flatpickr-day.startRange:hover, .flatpickr-day.endRange:hover, .flatpickr-day.selected.prevMonthDay, .flatpickr-day.startRange.prevMonthDay, .flatpickr-day.endRange.prevMonthDay, .flatpickr-day.selected.nextMonthDay, .flatpickr-day.startRange.nextMonthDay, .flatpickr-day.endRange.nextMonthDay {
        border-color: #499596;
        background: #499596;
    }
    .flatpickr-day.today {
        border-color: #499596;
    }
    .flatpickr-day.today:hover, .flatpickr-day.today:focus {
        border-color: #499596;
        background: #499596;
    }

    .flatpickr-day.selected.startRange + .endRange:not(:nth-child(7n+1)), .flatpickr-day.startRange.startRange + .endRange:not(:nth-child(7n+1)), .flatpickr-day.endRange.startRange + .endRange:not(:nth-child(7n+1)) {
        -webkit-box-shadow: -10px 0 0 #499596;
        box-shadow: -10px 0 0 #499596;
    }

    .accordion-button:focus {
        border-color: #499596;
        box-shadow: 0 0 0 0.25rem rgba(28, 132, 132, 0.25)
    }
    .accordion-button:not(.collapsed) {
        background-color: #fff;
        color: #455763;
    }

    .accordion-body {
        padding-left: 0.60rem;
        padding-right: 0.60rem;
    }
    .list-group-item p {
        font-size: 0.75rem;
    }
    .card-header, .card-footer {
        color: #455763;
    }

.plan-box {
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            cursor: pointer;
            transition: border-color 0.3s, box-shadow 0.3s;
            height: 100%;
            }
            .plan-box.selected {
                border-color: #0d6efd !important;
                box-shadow: 0 0 15px rgba(13, 110, 253, 0.3) !important;
                background-color: #f0f8ff;
            }
            .plan-title {
            font-weight: 600;
            font-size: 1.25rem;
            }
            .plan-subtitle {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 15px;
            }
            .plan-button {
            margin-bottom: 15px;
            }
            .plan-list {
            padding-left: 20px;
            }
    .form-range::-webkit-slider-thumb {
        background-color: #1C8484; /* Set your desired color */
        border: 1px solid #1C8484; /* Set border color if needed */
        }

        .form-range::-moz-range-thumb {
        background-color: #1C8484; /* Set your desired color */
        border: 1px solid #1C8484; /* Set border color if needed */
        }

        .form-range::-ms-thumb {
        background-color: #1C8484; /* Set your desired color */
        border: 1px solid #1C8484; /* Set border color if needed */
        }

        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            background-color: #1C8484;
        }
        .nav-pills>li>a, .nav-tabs>li>a {
            background-color: #499596;
            color: #fff;
        }
        .nav-link:focus, .nav-link:hover {
            color: #fff;
        }
    .icon-item {
        padding-left: 3px;
        padding-right: 3px;
        padding-top: 4px;
        padding-bottom: 1px;
    }
    .form-password-toggle .input-group-append {
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #1C8484;
        border-color: #1C8484;
    }
    .form-check-input:focus {
        border-color: #499596;
        box-shadow: 0 0 0 0.25rem rgba(28, 132, 132,.25)
    }
    .bg-primary {
        background-color: #1C8484 !important;
    }
    .fc .fc-button-primary {
        background-color: #1C8484 !important;
        border-color: #1C8484 !important;
    }
    .review-carousel .carousel-control-icon {
        color: #1C8484 ;
        background-color: rgba(28, 132, 132,.25)
    }
    .notice {
        position: fixed;
        left: 0;
        bottom: 0;
        margin: 0 !important;
        z-index: 999999999;
        border: 0;
        width: 100%;
        max-width: 100%;

        border-radius: 0;
    }
    .vertical-menu {
        min-width: 215px;
        max-widthh: 215px;
    }


    .form-check-input {
        border-color: #1C8484 !important;
    }
    .form-check-input:checked {
        background-color: #1C8484;
        border-color: #1C8484;
    }

    .form-check-input:focus {
        border-color: #499596;
        -webkit-box-shadow: 0 0 0 0.25rem rgba(28, 132, 132,.25);
        box-shadow: 0 0 0 0.25rem rgba(28, 132, 132,.25);
    }
    @media (min-width: 992px) {
        #toggle-menu-btn {
            display: initial;
        }
    }

    @media (max-width: 992px) {
        #toggle-menu-btn {
            display: none;
        }
    }
    div.dataTables_wrapper div.dataTables_filter input {
        margin-left: 0% !important;
    }
    .pagination{
        float: inline-end !important;
    }
    .vertical-collpsed .navbar-brand-box {
        width: 250px !important;
    }
    .my-loader {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        background: rgba(0, 0, 0, 0.25) url('{{ asset("public/assets/loader.svg") }}') no-repeat center center;
        background-size: 100px 100px;
        z-index: 10000;
    }

    /* canvas[data-engine="three.js r146"] {
        display: none !important;
    } */
        </style>
        <script>
            var baseUrl = "{{ url('/') }}";
        </script>
        @yield('css')
    </head>

    <body data-layout="detached" data-topbar="colored" >
        <div id="loader" class="loader d-none" style="position: fixed;left: 55%;top:50%;z-index: 1000">
            <div class="spinner-border " style="--falcon-text-opacity: 1;color: #1C8484;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div id="loader-overlay" class="loader-overlay d-none" style="position: fixed;width: 100%;height: 100%;background: rgba(28, 132, 132, 0.1);top: 0;z-index: 500"></div>

        @include('cookie-consent::index')


        <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <div class="container-fluid">
            <!-- Begin page -->
            <div id="layout-wrapper">
                @if(@$_GET['i'] != 'true')

                <header id="page-topbar" class="py-1">
                    <div class="navbar-header">
                        <div class="container-fluid">
                            <div class="float-end">

                                <div class="dropdown d-inline-block d-lg-none ms-2">
                                    <button type="button" class="btn header-item noti-icon waves-effect"
                                        id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="mdi mdi-magnify"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                        aria-labelledby="page-header-search-dropdown">

                                        <form class="p-3">
                                            <div class="m-0">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search ..."
                                                        aria-label="Recipient's username">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="submit"><i
                                                                class="mdi mdi-magnify"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>



                                <div class="dropdown d-inline-block">
                                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img class="rounded-circle header-profile-user"
                                        @if(Auth::user()->photo == null || Auth::user()->photo == "")
                                        src="{{ asset('public') }}/assets/profile.png"
                                        @else
                                    src="{{ asset('storage/app/public/Profiles/'.Auth::user()->photo) }}"
                                        @endif
                                            alt="Avatar">
                                        <span class="d-none d-xl-inline-block ms-1">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <span>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                                                <span style="font-size: 9px;">{{ Auth::user()->role == 'rep' ? 'Partner' : ucfirst(Auth::user()->role) }}</span>
                                            </div>
                                        </span>
                                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a class="dropdown-item" href="{{ url('/profile-settings') }}"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                                            Profile</a>

                                        <a class="dropdown-item text-danger" href="javascript:void(0);"  onclick="document.getElementById('logout-form').submit()"><i
                                                class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> Logout</a>
                                                <form method="POST" id="logout-form" action="{{ route('logout') }}">@csrf</form>
                                            </div>
                                </div>


                            </div>
                            <div>
                                <!-- LOGO -->
                                <div class="navbar-brand-box">
                                    <a href="{{ url('/home') }}" class="logo logo-dark">
                                        <span class="logo-sm">
                                            <img src="{{ asset('public') }}/assets/secret-logo.png" alt="" height="56">
                                        </span>
                                        <span class="logo-lg">
                                            <img src="{{ asset('public') }}/assets/secret-logo.png" alt="" height="53">
                                        </span>
                                    </a>

                                    <a href="{{ url('/home') }}" class="logo logo-light">
                                        <span class="logo-sm">
                                            <img src="{{ asset('public') }}/assets/secret-logo.png" alt="" height="56">
                                        </span>
                                        <span class="logo-lg">
                                            <img src="{{ asset('public') }}/assets/secret-logo.png" alt="" height="55">
                                        </span>
                                    </a>
                                </div>

                                <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                                    id="vertical-menu-btn">
                                    <i class="fa fa-fw fa-bars"></i>
                                </button>


                                <button type="button" class="btn btn-sm px-3 font-size-16 header-item d-none toggle-btn waves-effect"
                                id="toggle-menu-btn">
                                <i class="fa fa-fw fa-bars"></i>
                            </button>
                            </div>

                        </div>
                    </div>
                </header>

                {{-- <header id="page-topbar" class="py-1">
                    <div class="navbar-header">
                        <div class="container-fluid">
                            <div class="float-end">

                                <div class="dropdown d-inline-block d-lg-none ms-2">
                                    <button type="button" class="btn header-item noti-icon waves-effect"
                                        id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="mdi mdi-magnify"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                        aria-labelledby="page-header-search-dropdown">

                                        <form class="p-3">
                                            <div class="m-0">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search ..."
                                                        aria-label="Recipient's username">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="submit"><i
                                                                class="mdi mdi-magnify"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>



                                <div class="dropdown d-inline-block">
                                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img class="rounded-circle header-profile-user"
                                        @if(Auth::user()->photo == null || Auth::user()->photo == "")
                                        src="{{ asset('public') }}/assets/profile.png"
                                        @else
                                    src="{{ asset('storage/app/public/Profiles/'.Auth::user()->photo) }}"
                                        @endif
                                            alt="Avatar">
                                        <span class="d-none d-xl-inline-block ms-1">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <span>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                                                <span style="font-size: 9px;">{{ Auth::user()->role == 'rep' ? 'Partner' : ucfirst(Auth::user()->role) }}</span>
                                            </div>
                                        </span>
                                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a class="dropdown-item" href="{{ url('/profile-settings') }}"><i class="bx bx-user font-size-16 align-middle me-1"></i>
                                            Profile</a>

                                        <a class="dropdown-item text-danger" href="javascript:void(0);"  onclick="document.getElementById('logout-form').submit()"><i
                                                class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> Logout</a>
                                                <form method="POST" id="logout-form" action="{{ route('logout') }}">@csrf</form>
                                            </div>
                                </div>


                            </div>
                            <div>
                                <!-- LOGO -->
                                <div class="navbar-brand-box">
                                    <a href="{{ url('/home') }}" class="logo logo-dark">
                                        <span class="logo-sm">
                                            <img src="{{ asset('public') }}/assets/secret-logo.png" alt="" height="56">
                                        </span>
                                        <span class="logo-lg">
                                            <img src="{{ asset('public') }}/assets/secret-logo.png" alt="" height="53">
                                        </span>
                                    </a>

                                    <a href="{{ url('/home') }}" class="logo logo-light">
                                        <span class="logo-sm">
                                            <img src="{{ asset('public') }}/assets/secret-logo.png" alt="" height="56">
                                        </span>
                                        <span class="logo-lg">
                                            <img src="{{ asset('public') }}/assets/secret-logo.png" alt="" height="55">
                                        </span>
                                    </a>
                                </div>

                                <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                                    id="vertical-menu-btn">
                                    <i class="fa fa-fw fa-bars"></i>
                                </button>


                                <button type="button" class="btn btn-sm px-3 font-size-16 header-item d-none toggle-btn waves-effect" id="toggle-menu-btn">
                                    <i class="fa fa-fw fa-bars"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </header> --}}
                @endif
                @if(@$_GET['i'] != 'true')
                <!-- ========== Left Sidebar Start ========== -->
                <div class="vertical-menu" style="margin-bottom: 85px !important">


                    <div class="h-100">
                        <button type="button" class="btn btn-sm font-size-20 header-item toggle-btn waves-effect text-primary w-100"

                            id="toggle-menu-btn">
                            <i class="fa fa-fw fa-bars mt-1"></i>
                        </button>


                        <!--- Sidemenu -->
                        <div id="sidebar-menu">

                            <!-- Left Menu Start -->
                            <ul class="metismenu list-unstyled mt- 3" id="side-menu">

                                {{-- <li class="menu-title">Apps</li> --}}

                                <li class="{{ Request::is('home') || Request::is('') ? 'mm-active' : '' }}">
                                    <a href="{{ url('/home') }}" class=" waves-effect">
                                        <i class="mdi mdi-airplay"></i>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                                @if(Auth::user()->role != 'admin' && Auth::user()->role != 'superadmin' && Auth::user()->role != 'rep')
                                @if(Auth::user()->role == 'lab')
                                <li class="{{ Request::is('view-tasks') ? 'mm-active' : '' }}">
                                    <a href="{{ url('/view-tasks') }}" class=" waves-effect">
                                        <i class="mdi mdi-calendar-check-outline"></i>
                                        <span>New Tasks</span>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->role != 'rep' && Auth::user()->role != 'superadmin' && Auth::user()->role != 'admin')
                                <li class="{{ Request::is('integrations/3shape-setup') || Request::is('patient/demo') || Request::is('patient/create') || Request::is('patients/view') || Request::is('patients')  || Request::is('demo/patient/edit') ? 'mm-active' : '' }}">
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-account-heart-outline"></i>
                                        <span>Patient</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        @if(Auth::user()->role == 'staff')
                                        <li class="{{ Request::is('view-tasks/finished') ? 'mm-active' : '' }}"><a href="{{ url('/view-tasks2') }}">Tasks</a></li>
                                        <li class="{{ Request::is('view-tasks/under-process') ? 'mm-active' : '' }}"><a href="{{ url('/patients/view/under-process') }}">Under Process</a></li>
                                        <li class="{{ Request::is('view-tasks/delivered') ? 'mm-active' : '' }}"><a href="{{ url('/patients/delivered') }}">Delivered</a></li>
                                        <li class="{{ Request::is('view-tasks/delivered') ? 'mm-active' : '' }}"><a href="{{ url('/patients/cancelled') }}">Cancelled</a></li>
                                        @endif
                                        @if(Auth::user()->role == 'doctor')
                                            <li class="{{ Request::is('patient/create') ? 'mm-active' : '' }}"><a href="{{ url('/patient/create') }}">Create new patient</a></li>
                                        @endif

                                        @if(Auth::user()->role == 'doctor')
                                            <li class="{{ Request::is('patients') ? 'mm-active' : '' }}"><a href="{{ url('/patients') }}">Manage Patients</a></li>
                                            <li class="{{ Request::is('demo/patients/view') ? 'mm-active' : '' }}"><a href="{{ url('/demo/patients/view') }}">Demo Patients</a></li>
                                        @elseif (Auth::user()->role == 'staff')
                                            <li class="{{ Request::is('staff/patients') ? 'mm-active' : '' }}"><a href="{{ url('staff/patients') }}">Manage Patients</a></li>
                                        @elseif (Auth::user()->role == 'lab')
                                            <li class="{{ Request::is('lab/patients') ? 'mm-active' : '' }}"><a href="{{ url('/lab/patients') }}">Manage Patients</a></li>
                                        @else
                                            <li class="{{ Request::is('patients/view') ? 'mm-active' : '' }}"><a href="{{ url('/patients/view') }}">Manage Patients</a></li>
                                        @endif
                                    </ul>
                                </li>
                                @endif



                                @if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'rep')
                                <li class="{{ Request::is('orders') ? 'mm-active' : '' }}">
                                    <a href="{{ url('/orders') }}" class=" waves-effect">
                                        <i class="mdi mdi-package-variant"></i>
                                        <span>Orders</span>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->role == 'superadmin')
                                <li class="{{ Request::is('reports/lab-requests') ? 'mm-active' : '' }}">
                                    <a href="{{ url('/reports/lab-requests') }}" class=" waves-effect">
                                        <i class="mdi mdi-folder-information-outline"></i>
                                        <span>Lab Requests</span>
                                    </a>
                                </li>

                                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                <li class="{{ Request::is('patient/demo') || Request::is('demo/patient/edit') ? 'mm-active' : '' }}">
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-account-heart-outline"></i>
                                        <span>Demo Patients</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li class="{{ Request::is('demo/patient/edit') ? 'mm-active' : '' }}"><a href="{{ url('/demo/patient/edit') }}">Demo Patient</a></li>
                                    </ul>
                                </li>
                                @endif
                                @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'rep')
                                <li class="{{ Request::is('user/add') || Request::is('users/view') ? 'mm-active' : '' }}">
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-account-circle-outline"></i>
                                        <span>Users</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li class="{{ Request::is('user/add') ? 'mm-active' : '' }}"><a href="{{ url('/user/add') }}">Register</a></li>
                                        <li class="{{ Request::is('users/view') ? 'mm-active' : '' }}"><a href="{{ url('/users/view') }}">Manage</a></li>
                                    </ul>
                                </li>
                                @endif
                                <li class="{{ Request::is('events/view') || Request::is('events/add') || Request::is('events/edit/*') ? 'mm-active' : '' }}">
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-comment-text-outline"></i>
                                        <span>Events</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li class="{{ Request::is('events/add') ? 'mm-active' : '' }}"><a href="{{ url('/events/add') }}">Add New</a></li>
                                        <li class="{{ Request::is('events/view') ? 'mm-active' : '' }}"><a href="{{ url('/events/view') }}">Manage</a></li>
                                    </ul>
                                </li>
                                <li class="{{ Request::is('blogs/view') || Request::is('blog/add') || Request::is('blog/edit/*') ? 'mm-active' : '' }}">
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-comment-text-outline"></i>
                                        <span>Blogs</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li class="{{ Request::is('blog/add') ? 'mm-active' : '' }}"><a href="{{ url('/blog/add') }}">Add New</a></li>
                                        <li class="{{ Request::is('blogs/view') ? 'mm-active' : '' }}"><a href="{{ url('/blogs/view') }}">Manage</a></li>
                                    </ul>
                                </li>
                                <li class="{{ Request::is('tutorials/view') || Request::is('tutorial/add') || Request::is('tutorial/edit/*') ? 'mm-active' : '' }}">
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-comment-text-outline"></i>
                                        <span>Tutorials</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li class="{{ Request::is('tutorial/add') ? 'mm-active' : '' }}"><a href="{{ url('/tutorial/add') }}">Add New</a></li>
                                        <li class="{{ Request::is('tutorials/view') ? 'mm-active' : '' }}"><a href="{{ url('/tutorials/view') }}">Manage</a></li>
                                    </ul>
                                </li>
                                @else
                                @if(Auth::user()->role != 'doctor')
                                <li class="{{ Request::is('blogs') || Request::is('blog/*') ? 'mm-active' : '' }}">
                                    <a href="{{ url('/blogs') }}" class=" waves-effect">
                                        <i class="mdi mdi-comment-text-outline"></i>
                                        <span>Blogs</span>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->role == 'staff' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin')
                                <li class="{{ Request::is('patients/orders/finished/view') ? 'mm-active' : '' }}">
                                    <a href="{{ url('/patients/orders/finished/view') }}" class=" waves-effect">
                                        <i class="mdi mdi-package-variant-closed"></i>
                                        <span>Finished Orders</span>
                                    </a>
                                </li>

                                <li class="{{ Request::is('contracts/data-processing-documents/view') ? 'mm-active' : '' }}">
                                    <a href="{{ url('/contracts/data-processing-documents/view') }}" class=" waves-effect">
                                        <i class="mdi mdi-account-multiple-outline"></i>
                                        <span>Doctors</span>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->role == 'doctor')
                                <li class="{{ Request::is('events') ? 'mm-active' : '' }}">
                                    <a href="{{ url('/events') }}" class=" waves-effect">
                                        <i class="mdi mdi-comment-text-outline"></i>
                                        <span>Events</span>
                                    </a>
                                </li>
                                @endif
                                <li class="{{ Request::is('tutorials') || Request::is('tutorial/*') ? 'mm-active' : '' }}">
                                    <a href="{{ url('/tutorials') }}" class=" waves-effect">
                                        <i class="mdi mdi-comment-text-outline"></i>
                                        <span>Tutorials</span>
                                    </a>
                                </li>
                                @endif

                                @endif


                                @if(Auth::user()->role == 'rep')
                                <li class="{{ Request::is('patients/view') || Request::is('orders') ? 'mm-active' : '' }}">
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-account-heart-outline"></i>
                                        <span>Patient</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li class="{{ Request::is('patients/view') ? 'mm-active' : '' }}"><a href="{{ url('/patients/view') }}">View Patients</a></li>
                                        <li class="{{ Request::is('orders') ? 'mm-active' : '' }}"><a href="{{ url('/orders') }}">Orders</a></li>
                                    </ul>
                                </li>
                                <li class="{{ Request::is('partner/users/create') || Request::is('partner/users/') || Request::is('users/edit/*') ? 'mm-active' : '' }}">
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-account-circle-outline"></i>
                                        <span>Users</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li class="{{ Request::is('partner/users/create') ? 'mm-active' : '' }}"><a href="{{ url('/partner/users/create') }}">Register</a></li>
                                        <li class="{{ Request::is('partner/users/') ? 'mm-active' : '' }}"><a href="{{ url('/partner/users/') }}">Manage</a></li>
                                    </ul>
                                </li>
                                <li class="{{ Request::is('events') ? 'mm-active' : '' }}">
                                    <a href="{{ url('/events') }}" class=" waves-effect">
                                        <i class="mdi mdi-comment-text-outline"></i>
                                        <span>Events</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('tutorials') || Request::is('tutorial/*') ? 'mm-active' : '' }}">
                                    <a href="{{ url('/tutorials') }}" class=" waves-effect">
                                        <i class="mdi mdi-comment-text-outline"></i>
                                        <span>Tutorials</span>
                                    </a>
                                </li>
                                @endif

                                @if(Auth::user()->role == 'superadmin')
                                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                <li class="{{ Request::is('patients/view') || Request::is('superadmin/patients') || Request::is('reports/lab-requests') || Request::is('patients/secret-partner-requests') || Request::is('orders') || Request::is('demo/patients/view') || Request::is('demo/patient/edit') ? 'mm-active' : '' }}">
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-account-heart-outline"></i>
                                        <span>Patient</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        @if (Auth::user()->role == 'superadmin')
                                            <li class="{{ Request::is('superadmin/patients') ? 'mm-active' : '' }}"><a href="{{ url('superadmin/patients') }}">Manage Patients</a></li>
                                        @else
                                            <li class="{{ Request::is('patients/view') ? 'mm-active' : '' }}"><a href="{{ url('/patients/view') }}">Manage Patients</a></li>
                                        @endif

                                        <li class="{{ Request::is('orders') ? 'mm-active' : '' }}"><a href="{{ url('/orders') }}">Orders</a></li>
                                        <li class="{{ Request::is('reports/lab-requests') ? 'mm-active' : '' }}"><a href="{{ url('/reports/lab-requests') }}">Lab requests</a></li>
                                        <li class="{{ Request::is('patients/secret-partner-requests') ? 'mm-active' : '' }}"><a href="{{ url('/patients/secret-partner-requests') }}">Secret Partner requests</a></li>
                                        <li class="{{ Request::is('demo/patients/view') ? 'mm-active' : '' }}"><a href="{{ url('/demo/patients/view') }}">Demo Patients</a></li>
                                    </ul>
                                </li>
                                <li class="{{ Request::is('user/add') || Request::is('users/view') || Request::is('tier-settings') || Request::is('users/edit/*') ? 'mm-active' : '' }}">
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-account-circle-outline"></i>
                                        <span>Users</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li class="{{ Request::is('user/add') ? 'mm-active' : '' }}"><a href="{{ url('/user/add') }}">Register</a></li>
                                        <li class="{{ Request::is('users/view') ? 'mm-active' : '' }}"><a href="{{ url('/users/view') }}">Manage</a></li>
                                        <li class="{{ Request::is('tier-settings') ? 'mm-active' : '' }}"><a href="{{ url('/tier-settings') }}">Tiers</a></li>
                                    </ul>
                                </li>
                                <li class="{{ Request::is('events/view') || Request::is('events/add') || Request::is('events/edit/*') ? 'mm-active' : '' }}">
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-comment-text-outline"></i>
                                        <span>Events</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li class="{{ Request::is('events/add') ? 'mm-active' : '' }}"><a href="{{ url('/events/add') }}">Add New</a></li>
                                        <li class="{{ Request::is('events/view') ? 'mm-active' : '' }}"><a href="{{ url('/events/view') }}">Manage</a></li>
                                    </ul>
                                </li>
                                <li class="{{ Request::is('blogs/view') || Request::is('blog/add') || Request::is('blog/edit/*') ? 'mm-active' : '' }}">
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-comment-text-outline"></i>
                                        <span>Blogs</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li class="{{ Request::is('blog/add') ? 'mm-active' : '' }}"><a href="{{ url('/blog/add') }}">Add New</a></li>
                                        <li class="{{ Request::is('blogs/view') ? 'mm-active' : '' }}"><a href="{{ url('/blogs/view') }}">Manage</a></li>
                                    </ul>
                                </li>
                                <li class="{{ Request::is('tutorials/view') || Request::is('tutorial/add') || Request::is('tutorial/edit/*') ? 'mm-active' : '' }}">
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="mdi mdi-comment-text-outline"></i>
                                        <span>Tutorials</span>
                                    </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        <li class="{{ Request::is('tutorial/add') ? 'mm-active' : '' }}"><a href="{{ url('/tutorial/add') }}">Add New</a></li>
                                        <li class="{{ Request::is('tutorials/view') ? 'mm-active' : '' }}"><a href="{{ url('/tutorials/view') }}">Manage</a></li>
                                    </ul>
                                </li>
                                @endif
                                @endif
                            </ul>
                        </div>
                        <!-- Sidebar -->
                    </div>
                </div>
                <!-- Left Sidebar End -->
                @endif

                <!-- ============================================================== -->
                <!-- Start right Content here -->
                <!-- ============================================================== -->
                <div class="main-content">

                    @yield('content')

                    <footer class="footer" style="margin: 0px 25px 15px 25px; border-radius: 0.25rem; background-color: white">
                        <div class="container-fluid ">
                            <div class="row">
                                <div class="col-sm-6">
                                    <script>document.write(new Date().getFullYear())</script> © <a href="https://secretalign.com/">Secret Clear Aligner System</a>.
                                </div>
                                <div class="col-sm-6 d-flex justify-content-sm-end gap-3">
                                    <div class="">
                                    <a href="{{ url('/datenschutzerklarung') }}" target="_blank">Datenschutzerklärung​</a>
                                    </div>
                                    <div class="">
                                        <a href="https://secretalign.com/impressum/" target="_blank">Impressum</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
                <!-- end main content-->

            </div>
            <!-- END layout-wrapper -->

        </div>
        <!-- end container-fluid -->

        <!-- Right Sidebar -->

        <div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-body rightbar">
                <div class="right-bar">
                    <div data-simplebar class="h-100">
                        <div class="rightbar-title px-3 py-4">
                            <a href="javascript:void(0);" class="right-bar-toggle float-end" data-bs-dismiss="offcanvas" aria-label="Close" >
                                <i class="mdi mdi-close noti-icon"></i>
                            </a>
                            <h5 class="m-0">Settings</h5>
                        </div>

                        <!-- Settings -->
                        <hr class="mt-0" />
                        <h6 class="text-center mb-0">Choose Layouts</h6>

                        <div class="p-4">
                            <div class="mb-2">
                                <img src="{{ asset('public/qovex') }}/assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="">
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input type="checkbox" class="form-check-input theme-choice" id="light-mode-switch" checked />
                                <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                            </div>

                            <div class="mb-2">
                                <img src="{{ asset('public/qovex') }}/assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="">
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input type="checkbox" class="form-check-input theme-choice" id="dark-mode-switch"  />
                                <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                            </div>

                            <div class="mb-2">
                                <img src="{{ asset('public/qovex') }}/assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="">
                            </div>
                            <div class="form-check form-switch mb-5">
                                <input type="checkbox" class="form-check-input theme-choice" id="rtl-mode-switch" data-appStyle="{{ asset('public/qovex') }}/assets/css/app-rtl.min.css" />
                                <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                            </div>

                        </div>

                    </div>
                    <!-- end slimscroll-menu-->
                </div>
            </div>

        </div>


        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>




        @if(@$_GET['i'] != 'true')
        <div class="dropdown d-inline-block rounded-start" style="position: fixed; right:0;bottom: 50%;z-index: 999;background: #1C8484;">
            <button type="button" class="btn header-item noti-icon waves-effect rounded-start pb-0"
                id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="mdi mdi-bell-outline"></i>
                <span class="badge rounded-pill bg-danger" id="notifications-count">0</span>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                aria-labelledby="page-header-notifications-dropdown">
                <div class="p-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="m-0"> Notifications </h6>
                        </div>
                        <div class="col-auto">
                            <a href="{{ url('/view-notifications') }}" class="small"> View All</a>
                        </div>
                    </div>
                </div>
                <div data-simplebar style="max-height: 230px;overflow-y: scroll" id="notifications-dropdown">

                </div>
                {{-- <div class="p-2 border-top d-grid">
                    <a class="btn btn-sm btn-link font-size-14 " href="{{ url('/view-notifications') }}">
                        <i class="mdi mdi-arrow-right-circle me-1"></i> View All..
                    </a>
                </div> --}}
            </div>
        </div>
        @endif

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
        <div class="my-loader"></div>
        @include('layouts.modal')
        <!-- JAVASCRIPT -->
        <!-- JAVASCRIPT -->
        <script src="{{ asset('public/qovex') }}/assets/libs/jquery/jquery.min.js"></script>
        <script src="{{ asset('public/qovex') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('public/qovex') }}/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="{{ asset('public/qovex') }}/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="{{ asset('public/qovex') }}/assets/libs/node-waves/waves.min.js"></script>
        <script src="{{ asset('public/qovex') }}/assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="{{ asset('public/dashboard/') }}/assets/js/flatpickr.js"></script>

        <script src="{{  asset('public/assets/customjs/common-function.js') }}"></script>
        <script src="{{  asset('public/assets/customjs/ajaxfileupload.js') }}"></script>
        <script src="{{  asset('public/assets/customjs/jquery.form.min.js') }}"></script>
        <script src="{{  asset('public/assets/customjs/validate/jquery.validate.min.js') }}"></script>
        <script src="{{  asset('public/assets/customjs/validate/additional-methods.min.js') }}"></script>
        <script src="{{  asset('public/assets/plugins/ckeditor.js') }}"></script>


        <script src="{{ asset('public/qovex') }}/assets/js/app.js"></script>


    <script>
        $(document).ready(function () {
            $(document).on('click', '#toggle-menu-btn', function () {
                const layout = $(this).attr('aria-layout');
                if(layout == 'collapsed') {
                    $("body").removeClass('vertical-collpsed');
                    $(this).attr('aria-layout', '');
                } else {
                    $("body").addClass('vertical-collpsed');
                    $(this).attr('aria-layout', 'collapsed');
                }
            });
            $(document).on('click', '.form-password-toggle .input-group-append', function () {
                const
                $this = $(this),
                state = $this.attr('aria-toggle');
                if(state == 'true') {
                    $this.parent().find("input").attr('type', 'password');
                    $this.attr('aria-toggle', false);
                    $this.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    $this.parent().find("input").attr('type', 'text');
                    $this.attr('aria-toggle', true);
                    $this.find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const inputFields = document.querySelectorAll('input[type="text"], textarea');
            inputFields.forEach(function(input) {
                input.setAttribute('spellcheck', 'true');
            });
        });
    </script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
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
                        if (parseInt(count.value) > 9999) {
                            bell.innerHTML = "9999+";
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
            }, 100000);
    </script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script> --}}
    <script>
        const baseAssetPath = "{{ asset('public/assets') }}";
        $('.mySelect2').select2({
            closeOnSelect: false
        });

        function selectPlan(plan) {
            // Reset all plans
            document.querySelectorAll('.plan-box').forEach(p => {
                p.classList.remove('selected');
                p.querySelector('input[type="radio"]').checked = false;

                // switch to light version
                if (p.dataset.planType === 'treatment') {
                    p.style.backgroundImage = `url('${baseAssetPath}/Treatment-Plan-Service-light.svg')`;
                } else if (p.dataset.planType === 'aligners') {
                    p.style.backgroundImage = `url('${baseAssetPath}/Aligners-light.svg')`;
                }
            });

            // Activate selected plan
            plan.classList.add('selected');
            plan.querySelector('input[type="radio"]').checked = true;
            $("#submit-treatment-plan").attr('disabled', false);

            // switch to colored version
            if (plan.dataset.planType === 'treatment') {
                plan.style.backgroundImage = `url('${baseAssetPath}/Treatment-Plan-Service.svg')`;
            } else if (plan.dataset.planType === 'aligners') {
                plan.style.backgroundImage = `url('${baseAssetPath}/Aligners.svg')`;
            }
        }

        // Automatically select already checked plan on page load
        document.addEventListener("DOMContentLoaded", function () {
            const checkedPlan = document.querySelector('.plan-box input[type="radio"]:checked');
            if (checkedPlan) {
                selectPlan(checkedPlan.closest('.plan-box'));
            }
        });

        // function selectPlan(plan) {
        //     document.querySelectorAll('.plan-box').forEach(p => {
        //         p.classList.remove('selected');
        //         p.querySelector('input[type="radio"]').checked = false;
        //     });
        //     plan.classList.add('selected');
        //     plan.querySelector('input[type="radio"]').checked = true;
        //     $("#submit-treatment-plan").attr('disabled', false);
        // }


        // document.addEventListener("DOMContentLoaded", function () {
        //     const checkedPlan = document.querySelector('.plan-box input[type="radio"]:checked');
        //     if (checkedPlan) {
        //         selectPlan(checkedPlan.closest('.plan-box'));
        //     }
        // });
        // document.addEventListener('DOMContentLoaded', function () {
        //     const elements = document.querySelectorAll('.mySelect2');
        //     elements.forEach(el => {
        //         new Choices(el, JSON.parse(el.getAttribute('data-choices')));
        //     });
        // });
    </script>

    <script>
        // document.getElementById('savePreviewBtn').addEventListener('click', function() {
        $(document).on('click', '#savePreviewBtn', function () {

        const form = document.getElementById('treatmentForm');
        const nameInput = form.coworker_name;
        const errorDiv = document.getElementById('coworker_name_error');
        errorDiv.innerText = '';

        if (nameInput.value.trim() === '') {
            errorDiv.innerText = 'Coworker name is required';
            nameInput.focus();
            return;
        }

        const formData = new FormData(form);

        this.disabled = true;
        this.innerText = "Saving...";

        fetch(form.action, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(response => response.json())
        .then(data => {
            this.disabled = false;
            this.innerText = "Save & Preview";
            if (data.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('treatmentModal'));
                modal.hide();
                window.open(`/staff/treatment/preview/${data.id}`, '_blank');
            } else {
                alert('Something went wrong while saving.');
            }
        })
        .catch(error => {
            console.error(error);
            this.disabled = false;
            this.innerText = "Save & Preview";
            alert("Error saving form!");
        });
    });
    </script>

    </body>
</html>
