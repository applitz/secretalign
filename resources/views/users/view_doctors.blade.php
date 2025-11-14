@extends('layouts.app_base_horizontal')

@section('content')

<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Doctors</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Doctors</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="mt-2" method="GET" action="{{url()->current()}}">
                        <div class="row">
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
                                        <th scope="col">Signature</th>
                                        <th scope="col" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($doctors))
                                    @foreach ($doctors as $doctor)
                                    <tr class="align-middle">
                                        <td class="text-nowrap">
                                            <div class="flex-1">
                                                <span class="mb-1 fw-semi-bold text-dark">{{$doctor->first_name . ' ' .
                                                    $doctor->last_name}}</span>
                                            </div>

                                        </td>
                                        <td class="text-nowrap">{{$doctor->email}}</td>
                                        <td class="text-nowrpa">
                                            @if(@$doctor->data_processing_document_signatures)
                                            <img width="100" src="{{$doctor->data_processing_document_signatures}}">
                                            @endif
                                        </td>
                                        <td class="text-nowrap text-end">

                                            <div class="dropdown font-sans-serif btn-reveal-trigger">
                                                <a class="btn btn-link text-600 btn-sm btn-reveal-sm transition-none"
                                                    href="{{ url('/contract/view/data-processing-document/'.$doctor->id) }}"
                                                    data-boundary="viewport" aria-haspopup="true" aria-expanded="false">Data Processing Document</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <td class="text-center" colspan="4">
                                        No Data To Show
                                    </td>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{ $doctors->links('pagination::bootstrap-5') }}
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
