<!doctype html>
<html lang="en" >

<head>

    <meta charset="utf-8" />
    <title>Secret Clear Aligner | Dashboard &amp; Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('public') }}/assets/favicon.png">

    <!-- Bootstrap Css -->
    <link href="{{ asset('public/qovex') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('public/qovex') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('public/qovex') }}/assets/css/app.min.css"  id="app-style"  rel="stylesheet" type="text/css" />
    <style>
         .bg-login {
            background-image: url('{{asset('public/assets/IMG_4547.PNG')}}');
        }
        /* .bg-login {
            background: #105656;
        } */
        .bg-login-overlay {
            background: linear-gradient(to right,#1C8484, #1C8484);
            opacity: 0.125;
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
.form-control:focus {
    border-color: #499596;
    box-shadow: 0 0 0 0.25rem rgba(28, 132, 132,.25)
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


    </style>
</head>

<body>
    <div class="home-btn d-none">
        <a href="{{url('')}}" class="text-reset"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <!-- JAVASCRIPT -->
    <script src="{{ asset('public/qovex') }}/assets/libs/jquery/jquery.min.js"></script>
    <script src="{{ asset('public/qovex') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('public/qovex') }}/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="{{ asset('public/qovex') }}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('public/qovex') }}/assets/libs/node-waves/waves.min.js"></script>
    <script src="{{ asset('public/qovex') }}/assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

    <script src="{{ asset('public/qovex') }}/assets/js/app.js"></script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.password-toggle', function () {
            const state = $(this).attr('aria-state');
            if(state == '1') {
                $(this).html(`<i class="fas fa-eye"></i>`);
                $(this).parent().parent().find("input").attr('type', 'password');
                $(this).attr('aria-state', 0);
            } else {
                $(this).html(`<i class="fas fa-eye-slash"></i>`);
                $(this).parent().parent().find("input").attr('type', 'text');
                $(this).attr('aria-state', 1);
            }
        });
    });
</script>
</body>

</html>
