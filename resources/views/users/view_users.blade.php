@extends('layouts.app_base_horizontal')

@section('content')
<div class="page-content">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Users</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="mt-2" method="GET" action="{{url('/users/view')}}">
                        <div class="row">
                            @if (Auth::user()->role == 'superadmin')
                            <div class="col-md-3 mb-3">
                                <div class="row align-items-center g-3">
                                    <div class="col-12">
                                        <h6 class="text-700 mb-0">Role/Privileges</h6>
                                    </div>
                                    <div class="col-12 position-relative">
                                        <select class="form-select form-select-sm  @error('role') is-invalid @enderror" id="role"
                                            name="role">
                                            <option value="">Select role...</option>
                                            <option value="advisor" @if (@$_GET['role']=='advisor' ) selected @endif>Asvisor</option>
                                            <option value="doctor" @if (@$_GET['role']=='doctor' ) selected @endif>Doctor</option>
                                            <option value="staff" @if (@$_GET['role']=='staff' ) selected @endif>Staff</option>
                                            <option value="rep" @if (@$_GET['role']=='rep' ) selected @endif>Al-Secret Partner</option>
                                            <option value="lab" @if (@$_GET['role']=='lab' ) selected @endif>Lab Technician</option>
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
                                            value="{{@$_GET['search']}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="btn-group">
                                    <button class="btn btn-primary waves-effect waves-light btn-sm submit-filter-form" type="submit"><i
                                            class="fas fa-search me-2"></i> Filter</button>
                                    <a class="btn btn-warning waves-effect waves-light btn-sm" href="{{ url() ->current() }}"><i
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
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        @if(Auth::user()->role != 'rep')
                                        <th scope="col" class="text-center">Role/Privileges</th>
                                        @endif
                                        <th scope="col" class="text-center">Tier</th>
                                        @if(Auth::user()->role == 'superadmin')
                                        <th scope="col"></th>
                                        <th class="text-end" scope="col">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($users))
                                    @foreach ($users as $user)
                                    <tr class="align-middle">
                                        <td class="text-nowrap">
                                            <div class="flex-1">
                                                <span class="mb-1 fw-semi-bold text-dark">{{$user->first_name . ' ' .
                                                    $user->last_name}}</span>
                                                @if ($user->role == 'lab')
                                                <p class="fw-semi-bold mb-0 text-500">Lab Request ({{$user->lab_request_count}})</p>
                                                @endif
                                                @if ($user->role == 'doctor')
                                                <p class="fw-semi-bold mb-0 text-500">Patients ({{$user->patient_count}})</p>
                                                @endif
                                                @if ($user->role == 'rep')
                                                <p class="fw-semi-bold mb-0 text-500">Registered Doctors ({{$user->doctors_count}})</p>
                                                @endif
                                            </div>

                                        </td>
                                        <td class="text-nowrap">{{$user->email}}</td>
                                        @if(Auth::user()->role != 'rep')
                                        <td class="text-nowrap text-center">
                                            <span class="badge badge-soft-primary">
                                                @if($user->role == 'rep')
                                                Partner
                                                @else
                                                {{ucfirst($user->role)}}
                                                @endif
                                            </span>
                                        </td>
                                        @endif
                                        <td class="text-nowrap text-center">
                                            @if ($user->role == 'doctor')
                                            @if ($user->tier == 2)
                                            <span class="badge rounded-pill badge-soft-dark">{{$user->tier_name}}</span>
                                            @elseif($user->tier == 3)
                                            <span class="badge rounded-pill badge-soft-warning">{{$user->tier_name}}</span>
                                            @elseif($user->tier == 4)
                                            <span class="badge rounded-pill badge-soft-secondary">{{$user->tier_name}}</span>
                                            @elseif($user->tier == 5)
                                            <span class="badge rounded-pill badge-soft-info">{{$user->tier_name}}</span>
                                            @elseif($user->tier == 6)
                                            <span class="badge rounded-pill badge-soft-success">{{$user->tier_name}}</span>
                                            @endif
                                            @endif
                                        </td>
                                        @if(Auth::user()->role == 'superadmin')
                                        <td class="text-nowrap">
                                            @if($user->data_processing_document_signatures && $user->role == 'doctor')
                                            <a href="{{url('/contract/view/data-processing-document/'.$user->id)}}">Data Processing Document</a>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div>
                                                <a class="btn p-0" href="{{url('/user/edit/'.$user->id)}}" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="" data-bs-original-title="Edit"
                                                    aria-label="Edit"><i
                                                    class="fas fa-edit"></i></a>
                                                @if($user->role != 'superadmin' && $user->role != 'doctor')
                                                <a class="btn p-0 ms-2 delete" data-id="{{$user->id}}" data-name="{{$user->email}}"
                                                    href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                    data-bs-original-title="Delete" aria-label="Delete"><i
                                                    class="fas fa-trash-alt"></i></a>
                                                @endif
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    @else
                                    <td class="text-center" @if (Auth::user()->role == 'superadmin')
                                        colspan="5"
                                        @else
                                        colspan="4"
                                        @endif>
                                        No Data To Show
                                    </td>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{ $users->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<form id="delete-user" method="POST">
    @csrf()
</form>
@stop

@section('javascript')
@include('layouts.page_scripts')
<script>
    $(document).ready(function () {
        $(document).on('click', '.delete', function () {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var c = confirm("Are you really want to delete "+name);
            if(c){
                var url = "{{url('')}}/user/delete/"+id;
                $("#delete-user").attr('action', url);
                $("#delete-user").submit();
            }
        })
    })
</script>
@stop
