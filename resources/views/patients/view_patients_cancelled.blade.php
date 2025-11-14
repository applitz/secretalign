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
                <h4 class="page-title mb-0 font-size-18">Cancelled Cases</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Patients</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="mt-2" method="GET" action="{{ url()->current() }}">
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
                            @if (Auth::user()->role != 'doctor')
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
                            @endif
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
                                    <a class="btn btn-warning waves-effect waves-light btn-sm" href="{{ url()->current() }}"><i
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
                                        <th scope="col"><a href="javascript:void(0);">ID</a></th>
                                        @if (Auth::user()->role != 'doctor' && Auth::user()->role != 'lab')
                                        <th scope="col"><a
                                                href="{{ url()->current() }}?search={{@$_GET['search']}}&doctor={{@$_GET['doctor']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=u.first_name">Doctor</a>
                                        </th>
                                        @endif
                                        <th scope="col"><a
                                                href="{{ url()->current() }}?search={{@$_GET['search']}}&doctor={{@$_GET['doctor']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=p.last_name">Last
                                                Name</a></th>
                                        <th scope="col"><a
                                                href="{{ url()->current() }}?search={{@$_GET['search']}}&doctor={{@$_GET['doctor']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=p.first_name">First
                                                Name</a></th>
                                        <th scope="col"><a
                                                href="{{ url()->current() }}?search={{@$_GET['search']}}&doctor={{@$_GET['doctor']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=p.dob">Birth
                                                Date</a></th>
                                                <th scope="col"><a
                                                    href="javascript:void(0);">Package</a></th>
                                        {{-- <th scope="col">Lab</th>
                                        <th scope="col">Treatment Plan</th> --}}
                                        <th scope="col"><a
                                                href="{{ url()->current() }}?search={{@$_GET['search']}}&doctor={{@$_GET['doctor']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=tp.status">Status</a>
                                        </th>
                                        <th scope="col"><a
                                                href="{{ url()->current() }}?search={{@$_GET['search']}}&doctor={{@$_GET['doctor']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=tp.cancellation_date">Due
                                                Date</a></th>
                                        <th scope="col"><a
                                                href="{{ url()->current() }}?search={{@$_GET['search']}}&doctor={{@$_GET['doctor']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=tp.setup_approval_date">Setup
                                                Approval Date</a></th>
                                        <th class="text-end" scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($patients))
                                    @foreach ($patients as $patient)
                                    <tr class="align-middle">
                                        <td class="text-nowrap">{{$hashids->encode($patient->id)}}</td>
                                        @if (Auth::user()->role != 'doctor' && Auth::user()->role != 'lab')
                                        <td class="text-nowrap">
                                            {{ ucfirst($patient->d_first_name . ' ' . $patient->d_last_name) }}
                                        </td>
                                        @endif
                                        <td class="text-nowrap">{{ $patient->last_name }}</td>
                                        <td class="text-nowrap">{{ $patient->first_name }}</td>
                                        <td class="text-nowrap">{{ $patient->dob }}</td>
                                        <td class="text-nowrap">
                                            @if($patient->pricing_package == 'AL-SECRET-CONFIDENCE')
                                            <span class="badge fw-semi-bold rounded-pill status badge-soft-primary">Confidence</span>
                                            @else
                                            <span class="badge fw-semi-bold rounded-pill status badge-soft-primary">Select</span>
                                            @endif
                                        </td>
                                        {{-- <td class="text-nowrap">{{ @$patient->lab_first_name . ' ' . @$patient->lab_last_name }}
                                        </td>
                                        <td class="text-nowrap">
                                            <span class="badge fw-semi-bold rounded-pill treatment-plan badge-soft-primary">{{
                                                ucfirst('Phase ' . $patient->phase) }}</span>
                                        </td> --}}
                                        <td>
                                            @if ($patient->status == 'In Progress')
                                            <span class="badge fw-semi-bold rounded-pill status badge-soft-primary">{{
                                                ucfirst($patient->status) }}</span>
                                            @elseif($patient->status == 'Production')
                                            <span class="badge fw-semi-bold rounded-pill status badge-soft-success">{{
                                                ucfirst($patient->status) }}</span>
                                            @elseif($patient->status == 'Waiting Staff Review')
                                            <span class="badge fw-semi-bold rounded-pill status badge-soft-warning">{{
                                                ucfirst($patient->status) }}</span>
                                            @elseif($patient->status == 'Waiting Lab Review')
                                            <span class="badge fw-semi-bold rounded-pill status badge-soft-warning">{{
                                                ucfirst($patient->status) }}</span>
                                                @elseif($patient->status == "Waiting Dr's Review")
                                                <span class="badge fw-semi-bold rounded-pill status badge-soft-warning">{{
                                                    ucfirst($patient->status) }}</span>
                                                @elseif($patient->status == "Waiting for Review from Advisor")
                                                <span class="badge fw-semi-bold rounded-pill status badge-soft-warning">{{
                                                    ucfirst("Waiting Advisor's Review") }}</span>
                                            @elseif($patient->status == 'Treatment Plan Completed')
                                            <span class="badge fw-semi-bold rounded-pill status badge-soft-info">{{
                                                ucfirst($patient->status) }}</span>
                                            @elseif($patient->status == 'Cancelled By Lab')
                                            <span class="badge fw-semi-bold rounded-pill status badge-soft-warning">{{
                                                ucfirst($patient->status) }}</span>
                                            @elseif($patient->status == 'Cancelled')
                                            <span class="badge fw-semi-bold rounded-pill status badge-soft-danger">{{
                                                ucfirst($patient->status) }}</span>
                                            @elseif($patient->status == 'Pending')
                                            <span class="badge fw-semi-bold rounded-pill status badge-soft-secondary">{{
                                                ucfirst($patient->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            @if($patient->is_completed == 1)
                                            {{date("Y-m-d", strtotime($patient->treatment_plan_duration))}}
                                            @else
                                            @if(@$patient->cancellation_date)
                                            {{date("Y-m-d", strtotime("-1 day", strtotime(date("Y-m-d",
                                            strtotime($patient->cancellation_date)))))}}
                                            @endif
                                            @endif

                                        </td>
                                        <td class="text-nowrap">


                                            @if(@$patient->setup_approval_date)
                                            {{date("Y-m-d", strtotime($patient->setup_approval_date))}}
                                            @endif
                                        </td>
                                        <td class="text-nowrap text-end">

                                            <div class="dropdown font-sans-serif btn-reveal-trigger">
                                                <a class="btn btn-link text-600 btn-sm btn-reveal-sm transition-none"
                                                    href="{{ url('/patient/case-overview/' . $hashids->encode($patient->treatment_plan)) }}"
                                                    data-boundary="viewport" aria-haspopup="true" aria-expanded="false">Case
                                                    Overview</a>
                                            </div>
                                        </td>

                                    </tr>
                                    @endforeach
                                    @else
                                    <td class="text-center" @if (Auth::user()->role != 'doctor' && Auth::user()->role != 'lab')
                                        colspan="7"
                                        @else

                                        colspan="6" @endif>
                                        No Data To Show
                                    </td>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{ $patients->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>



{{-- <form id="delete-patient" method="POST">
    @csrf()
</form> --}}
@stop

@section('javascript')

<script>
    const fp = flatpickr($(".pickr"), {
            "mode": "range"
        });
        $(document).ready(function() {
            $(document).on('click', '.delete', function() {
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                var c = confirm("Are you really want to delete " + name);
                if (c) {
                    var url = "{{ url('') }}/patient/delete/" + id;
                    $("#delete-patient").attr('action', url);
                    $("#delete-patient").submit();
                }
            })
        })
</script>
@stop
