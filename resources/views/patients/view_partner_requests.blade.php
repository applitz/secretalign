@extends('layouts.app_base_horizontal')

@section('content')

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Patients</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Secret Partner Requests</li>
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
                            <div class="col-md-3 mb-3">
                                <div class="row align-items-center g-3">
                                    <div class="col-12">
                                        <h6 class="text-700 mb-0">Partner: </h6>
                                    </div>
                                    <div class="col-12 position-relative">
                                        <select class="form-select form-select-sm mySelect2" id="organizerSingle" size="1"
                                            name="partner" data-options='{"removeItemButton":true,"placeholder":true}'>
                                            <option value="">Select partner...</option>
                                            @foreach ($partners as $partner)
                                            <option value="{{ $partner->id }}" @if ($partner->id == @$_GET['partner']) selected @endif>
                                                {{ $partner->first_name . ' ' . $partner->last_name }}</option>
                                            @endforeach
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
                                        <th scope="col"><a
                                            href="{{ url()->current() }}?search={{@$_GET['search']}}&partner={{@$_GET['partner']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=r.first_name">Partner</a>
                                    </th>
                                        <th scope="col"><a
                                            href="{{ url()->current() }}?search={{@$_GET['search']}}&partner={{@$_GET['partner']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=u.first_name">Doctor</a>
                                    </th>
                                        <th scope="col"><a
                                                href="{{ url()->current() }}?search={{@$_GET['search']}}&partner={{@$_GET['partner']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=p.last_name">Patient</a></th>
                                        <th scope="col"><a
                                                href="{{ url()->current() }}?search={{@$_GET['search']}}&partner={{@$_GET['partner']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=p.dob">Birth
                                                Date</a></th>
                                                <th scope="col"><a
                                                    href="javascript:void(0);">Package</a></th>
                                        {{-- <th scope="col">Lab</th>
                                        <th scope="col">Treatment Plan</th> --}}
                                        <th scope="col"><a
                                                href="{{ url()->current() }}?search={{@$_GET['search']}}&doctor={{@$_GET['doctor']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=tp.status">Status</a>
                                        </th>
                                        <th scope="col"><a
                                                href="javascript:void(0);">Amount</a></th>
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
                                        <td class="text-nowrap">
                                            {{ ucfirst($patient->r_first_name . ' ' . $patient->r_last_name) }}
                                        </td>
                                        <td class="text-nowrap">
                                            {{ ucfirst($patient->d_first_name . ' ' . $patient->d_last_name) }}
                                        </td>
                                        <td class="text-nowrap">{{ $patient->first_name . ' ' . $patient->last_name }}</td>
                                        <td class="text-nowrap">{{ $patient->dob }}</td>
                                        <td class="text-nowrap">
                                            @if($patient->pricing_package == 'AL-SECRET-CONFIDENCE')
                                            <span class="badge fw-semi-bold rounded-pill status badge-soft-primary">Confidence</span>
                                            @else
                                            <span class="badge fw-semi-bold rounded-pill status badge-soft-primary">Select</span>
                                            @endif
                                        </td>
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
                                          @php
                                       $date = @$_GET['date'];
$amount = DB::table('p_treatment_plans as tp')
    ->where('tp.patient_id', $patient->id)
    ->where('tp.is_completed', 1)
    ->where('tp.is_deleted', 0)
    ->where('tp.is_rejected', 0)
    ->where('tp.is_cancelled', 0)
    ->join("orders as o", function ($join) use ($date) {
        if (!empty($date)) {
            if (str_contains($date, 'to')) {
                $date = \explode('to', $date);
                $start = trim($date[0]);
                $end = trim($date[1]);
                $join->where('o.datetime', '>=', date('Y-m-d', strtotime($start)) . ' 00:00:00')
                     ->where('o.datetime', '<=', date('Y-m-d', strtotime($end)) . ' 23:59:59');
            } else {
                $join->where('o.datetime', '>=', date('Y-m-d', strtotime($date)) . ' 00:00:00')
                     ->where('o.datetime', '<=', date('Y-m-d', strtotime($date)) . ' 23:59:59');
            }
        }
    })
    ->sum('o.deposit');
                                          @endphp
    €{{number_format($amount, 2)}}
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
