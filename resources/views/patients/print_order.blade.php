<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Secret Clear Aligner System</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <script src="{{ asset('public/dashboard') }}/assets/js/config.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/overlayscrollbars/OverlayScrollbars.min.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('public/dashboard') }}/vendors/overlayscrollbars/OverlayScrollbars.min.css" rel="stylesheet">
    <link href="{{ asset('public/dashboard') }}/assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('public/dashboard') }}/assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="{{ asset('public/dashboard') }}/assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('public/dashboard') }}/assets/css/user.min.css" rel="stylesheet" id="user-style-default">
    <style>
        @media print {
            .noprint {
                display: none !important;
            }

            .printyes {
                display: block !important;
            }

            body {
                -webkit-print-color-adjust: exact !important;
            }
        }

        .printyes {
            display: none;
        }

        @page {
            margin: 0;
        }



        @media print {
            body {
                zoom: 100%;
            }
        }

        @media print {
            @page {
                size: A3;
            }
        }
    </style>
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


<body onload="window.print()" style="background-color: #fff !important;">

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container-fluid px-0" data-layout="container-fluid">
            <div class="content">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center text-center mb-3">
                            <div class="col-sm-6 text-sm-start"><img
                                    src="{{ asset('public') }}/assets/secret-logo.png" alt="Secret Clear Aligner System"
                                    width="350" /></div>
                            <div class="col text-sm-end mt-3 mt-sm-0">
                                <h2 class="mb-3">Invoice</h2>
                                <h5>Secret Clear Aligner System</h5>
                                <p class="fs--1 mb-0">© {{ date('Y') }} Secret Clear Aligner System</p>
                            </div>
                            <div class="col-12">
                                <hr />
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-500">Invoice to</h6>
                                <h5>{{ $order->first_name . ' ' . $order->last_name }}</h5>
                                <h5>Tier {{ $order->tier_name }}</h5>
                                <p class="fs--1">{!! $order->billing_address !!}</p>
                                <p class="fs--1"><a href="mailto:{{ $order->email }}">{{ $order->email }}</a><br /><a
                                        href="tel:{{ $order->phone_number }}">{{ $order->phone_number }}</a></p>
                            </div>
                            <div class="col-sm-auto ms-auto">
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless fs--1">
                                        <tbody>
                                            <tr>
                                                <th class="text-sm-end">Order Number:</th>
                                                <td>
                                                    {{ $hashids->encode($order->id) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-sm-end">Invoice Date:</th>
                                                <td>{{ date('d/m/Y', strtotime($order->datetime)) }}</td>
                                            </tr>
                                            {{-- <tr>
                                                <th class="text-sm-end">Payment Via:</th>
                                                <td>Stripe</td>
                                            </tr> --}}
                                            <tr class="alert-success fw-bold">
                                                <th class="text-sm-end">Amount Paid:</th>
                                                <td>€{{ number_format($order->deposit, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive scrollbar mt-4 fs--1">
                            <table class="table table-striped border-bottom">
                                <thead class="light">
                                    <tr class="bg-soft-warning  dark__bg-1000">
                                        <th class="border-0">Items</th>
                                        <th class="border-0 text-center">Quantity</th>
                                        <th class="border-0 text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle">
                                            <h6 class="mb-0 text-nowrap">Treatment Plan: Phase-{{ $order->phase }}
                                                {{ $order->p_first_name . ' ' . $order->p_last_name }}</h6>
                                            <p class="mb-0">Package: {{ $order->pricing_package == 'AL-SECRET-SELECT' ? 'SECRET SELECT' : 'SECRET CONFIDENCE' }}</p>
                                            <p class="mb-0">Aligners: {{ $order->aligner_steps }}</p>
                                            <p class="mb-0">Arch:
                                                {{ $order->treat_upper_arch == 1 && $order->treat_lower_arch == 1 ? 'Two' : 'One' }}
                                            </p>

                                        </td>
                                        <td class="align-middle text-center">
                                            {{ $order->treat_upper_arch == 1 && $order->treat_lower_arch == 1 ? '2' : '1' }}
                                        </td>
                                        <td class="align-middle text-end">€{{ $order->deposit }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-auto">
                                <table class="table table-sm table-borderless fs--1 text-end">
                                    <tr>
                                        <th class="text-900">Subtotal:</th>
                                        <td class="fw-semi-bold">€{{ number_format($order->deposit, 2) }} </td>
                                    </tr>
                                    <tr>
                                        <th class="text-900">Tax 0%:</th>
                                        <td class="fw-semi-bold">€0.00</td>
                                    </tr>
                                    <tr class="border-top">
                                        <th class="text-900">Total:</th>
                                        <td class="fw-semi-bold">€{{ number_format($order->deposit, 2) }}</td>
                                    </tr>
                                    <tr class="border-top border-top-2 fw-bolder text-900">
                                        <th>Amount Paid:</th>
                                        <td>€{{ number_format($order->deposit, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <p class="fs--1 mb-0"><strong>Notes: </strong>We really appreciate your business and if there’s
                            anything else we can do, please let us know!</p>
                    </div>
                </div>
                <footer class="footer">
                    <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600">Thank you for using Secret Clear Aligner System <span
                                    class="d-none d-sm-inline-block">| </span><br class="d-sm-none" />
                                {{ date('Y') }} &copy;</p>
                        </div>
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600">All rights reserved</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->



    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('public/dashboard') }}/vendors/popper/popper.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/anchorjs/anchor.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/is/is.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/fontawesome/all.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ asset('public/dashboard') }}/vendors/list.js/list.min.js"></script>
    <script src="{{ asset('public/dashboard') }}/assets/js/theme.js"></script>

</body>

</html>
