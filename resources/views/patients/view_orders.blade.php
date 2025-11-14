@extends('layouts.app_base_horizontal')


@section('content')
<style>
/* Match Bootstrap's form-select-sm */
.choices__inner {
    position: relative;
    min-height: 20px !important;
    padding-top: 0rem !important;
    padding-bottom: 0rem !important;
    padding-left: 0.5rem !important;
    font-size: 0.765rem !important; /* Matches .form-select-sm */
    /* font-weight: 200 !important; */
    /* border: var(--bs-border-width) solid #f6f6f6; */
    border-radius: 0.2rem !important; /* Matches Bootstrap's small input radius */
}

/* Ensure consistency with form-select border and background */
.choices__inner,
.choices__list--dropdown,
.choices__list[aria-expanded] {
    border-color: #f6f6f6 !important;
    font-size: 0.765rem !important;
    background-color: #fff !important;
    padding-inline: -internal-auto-base(2px, 0.5em);
        font-weight: 400 !important;
    color: -internal-auto-base(inherit, CanvasText) !important;
    overflow: hidden !important;
}
.choices__list--dropdown .choices__item--selectable.is-highlighted,
.choices__list[aria-expanded] .choices__item--selectable.is-highlighted {
    background-color: #0d6efd !important; /* Bootstrap primary blue */
    color: #fff !important;               /* Ensure text is readable */
}
.choices__input--cloned {
    color:rgba(121, 117, 117, 0.71) !important;           /* Text color (blue) */
    font-weight: 400;                    /* Bold text */
    font-size: 0.800rem !important;             /* Match Bootstrap form-select-sm */
   /* padding: 0.25rem 0.5rem !important;  /* Optional: Adjust padding */
}


/* Remove extra padding inside the dropdown */
.choices__list--dropdown .choices__item {
    padding: 3px 5px !important;
   font-size: 0.765rem !important;
    font-weight: 400 !important;
    padding-inline: -internal-auto-base(2px, 0.5em);
    overflow: hidden !important;
}

/* Match arrow styling and size */
.choices[data-type*="select-one"]::after {
    font-size: 0.765rem !important;
    font-weight: 400 !important;
    margin-top: -2px;
    right: 10px;
}

/* Optional: Reduce vertical spacing between doctor and select */
#organizerSingle {
    margin-top: 0.25rem;
}

    </style>
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Orders</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="card-title">Tasks</h4>
                    <p class="card-title-desc">Unfinished Tasks</p> --}}
                    <form class="mt-2" method="GET" action="{{ url('/orders') }}">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="row align-items-center g-3">
                                    <div class="col-12">
                                        <h6 class="text-700 mb-0">Date: </h6>
                                    </div>
                                    <div class="col-12 position-relative">
                                        <input class="form-control form-control-sm pickr ps-4" name="date" id="CRMDateRange"
                                            value="{{ @$_GET['date'] }}" placeholder="Y-m-d to Y-m-d" type="text"
                                            data-options="{&quot;mode&quot;:&quot;range&quot;,&quot;dateFormat&quot;:&quot;M d&quot;,&quot;disableMobile&quot;:true , &quot;defaultDate&quot;: [&quot;Aug 15&quot;, &quot;Aug 22&quot;] }" /><span
                                            class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2">
                                        </span>
                                    </div>
                                </div>
                            </div>
 <div class="col-md-3 mb-3">
    <div class="row align-items-center g-3">
        <div class="col-12">
            <h6 class="text-700 mb-0">Doctor: </h6>
        </div>
        <div class="col-12 position-relative">
<select
    class="form-select form-select-sm mySelect2"
    id="organizerSingle"
    name="doctor"
    data-choices='{
        "searchEnabled": true,
        "removeItemButton": false,
        "placeholderValue": "Select doctor..."
    }'>
    <option value="">Select doctor...</option>
    @foreach ($doctors as $doctor)
        <option value="{{ $doctor->id }}" {{ request('doctor') == $doctor->id ? 'selected' : '' }}>
            {{ $doctor->first_name . ' ' . $doctor->last_name }}
        </option>
    @endforeach
</select>
</div>
    </div>
</div>
                            <div class="col-md-3 mb-3">
                                <div class="row align-items-center g-3">
                                    <div class="col-12">
                                        <h6 class="text-700 mb-0">Status: </h6>
                                    </div>
                                    <div class="col-12 position-relative">
                                        <select class="form-select form-select-sm mySelect2" id="statuChooser"
                                            name="status" data-options='{"removeItemButton":true,"placeholder":true}'>
                                            <option value="">Any</option>
                                            @foreach($statusOptions as $status)
                                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                            @endforeach
                                            <!-- <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="completed" {{ request()->status == 'completed' ? 'selected' : '' }}>Completed</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="row align-items-center g-3">
                                    <div class="col-12">
                                        <h6 class="text-700 mb-0">Search: </h6>
                                    </div>
                                    <div class="col-12 position-relative">
                                        <input class="form-control form-control-sm" id="search" name="search" placeholder="Search"
                                            value="{{ @$_GET['search'] }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="btn-group">
                                    <button class="btn btn-primary waves-effect waves-light btn-sm submit-filter-form" type="submit"><i
                                            class="fas fa-search me-2"></i> Filter</button>
                                    <a class="btn btn-warning waves-effect waves-light btn-sm" href="{{ url('/orders') }}"><i
                                            class="fas fa-trash-alt me-2"></i> Clean Filters</a>
                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="tech-companies-1" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Order</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Patient</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Total</th>
                                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                        <th scope="col">Tracking Nr.</th>
                                        @endif
                                        <th scope="col" class="text-end"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if (count($orders))
                                    @foreach ($orders as $order)
                                    <tr class="align-middle">
                                        <td class="text-nowrap">
                                            {{ '#' . $hashids->encode($order->id) . ' ' . $order->first_name . ' ' . $order->last_name }}</td>
                                        <td class="text-nowrap">{{ date('d/m/Y', strtotime($order->datetime)) }}</td>
                                        <td class="text-nowrap">{{ $order->p_first_name . ' ' . $order->p_last_name }}</td>
                                        <td class="text-nowrap">
                                            @if ($order->status == 'completed')
                                            <span class="badge rounded-pill badge-soft-success">Completed</span>
                                            @elseif ($order->status == 'cancelled')
                                            <span class="badge rounded-pill badge-soft-danger">Cancelled</span>
                                            @else
                                            <span class="badge rounded-pill badge-soft-secondary">{{ $order->status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            €{{ number_format($order->deposit, 2) }}
                                        </td>
                                        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                        <td class="text-nowrap">
                                            @if($order->tracking_id)
                                            <a class="btn bg-soft-primary btn-link" href="{{$order->tracking_id}}" target="_blank">Tracking Nr.</a>
                                            @endif
                                        </td>
                                        @endif
                                        <td class="text-nowrap text-end">
                                            <a class="btn p-0" href="{{ url('/orders/print/' . $hashids->encode($order->id)) }}?view=print"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Print"
                                                aria-label="Print"><i class="fas fa-print"></i></a>
                                            <a class="btn p-0" href="{{ url('/orders/print/' . $hashids->encode($order->id)) }}" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="" data-bs-original-title="View" aria-label="View"><i
                                                    class="far fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <td class="text-center" colspan="6">
                                        No Data To Show
                                    </td>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{ $orders->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@stop

@section('javascript')

<script>
    const fp = flatpickr($(".pickr"), {
            "mode": "range"
        });
</script>
@stop
