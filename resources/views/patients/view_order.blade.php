@extends('layouts.app_base_horizontal')


@section('content')

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Orders</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/orders')}}">Orders</a></li>
                        <li class="breadcrumb-item active">See Order</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md">
                            <h5 class="mb-2 mb-md-0">
                                Order #{{ $hashids->encode($order->id) }}
                            </h5>
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0"
                                href="{{ Request()->url . '?view=print' }}"><span class="fas fa-print me-1"> </span>Print</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center text-center mb-3">
                        <div class="col-sm-6 text-sm-start"><img src="{{ asset('public') }}/assets/secret-logo.png"
                                alt="Secret Clear Aligner System" width="350" /></div>
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
                                        {{ $order->treat_upper_arch == 1 && $order->treat_lower_arch == 1 ? '2' : '1' }}</td>
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
                    <p class="fs--1 mb-0"><strong>Notes: </strong>We really appreciate your business and if there’s anything else we
                        can do, please let us know!</p>
                </div>
            </div>
        </div>
    </div>


</div>



@stop
