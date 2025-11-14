@extends('layouts.app_base_horizontal')

@section('content')

<div class="page-content">
    <div class="row">
        <div class="col-10">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Patients</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Demo Patients</li>
                    </ol>
                </div>
            </div>
        </div>
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
        <div class="col-2 text-end">
            <button class="btn btn-light" onclick="window.location.href='{{url('/demo/patient/add')}}'">Add Demo Patient</button>
        </div>
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="mt-2" method="GET" action="{{ url('/patients') }}">
                        <div class="row">

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
                                                href="{{ url()->current() }}?search={{@$_GET['search']}}&doctor={{@$_GET['doctor']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=p.last_name">Last
                                                Name</a></th>
                                        <th scope="col"><a
                                                href="{{ url()->current() }}?search={{@$_GET['search']}}&doctor={{@$_GET['doctor']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=p.first_name">First
                                                Name</a></th>
                                        <th scope="col"><a
                                                href="{{ url()->current() }}?search={{@$_GET['search']}}&doctor={{@$_GET['doctor']}}&orderBy={{ @$_GET['orderBy'] == 'asc' ? 'desc' : 'asc' }}&col=p.dob">Birth
                                                Date</a></th>

                                        <th class="text-end" scope="col"></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($patients))
                                    @foreach ($patients as $patient)
                                    <tr class="align-middle">
                                        <td class="text-nowrap">{{$hashids->encode($patient->id)}}</td>

                                        <td class="text-nowrap">{{ $patient->last_name }}</td>
                                        <td class="text-nowrap">{{ $patient->first_name }}</td>
                                        <td class="text-nowrap">{{ $patient->dob }}</td>
                                        <td class="text-nowrap">
                                            <a class="btn p-0" href="{{ url('/patient/demo/' . $hashids->encode($patient->id)) }}" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="" data-bs-original-title="View" aria-label="View"><i
                                                    class="far fa-eye"></i></a>
                                            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                            <a class="btn p-0 ms-2 delete" data-id="{{$patient->id}}" data-name="{{$patient->first_name . ' ' . $patient->last_name}}"
                                                href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                data-bs-original-title="Delete" aria-label="Delete"><i
                                                class="fas fa-trash-alt"></i></a>
                                                @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <td class="text-center"colspan="5">
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
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
        $(document).ready(function() {
            $(document).on('click', '.delete', function() {
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                var c = confirm("Are you really want to delete " + name);
                if (c) {
                    var url = "{{ url('') }}/demo/patient/delete/" + id;
                 window.location.href = url;
                }
            })
        })
        @endif
</script>

@stop
